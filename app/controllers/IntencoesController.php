<?php

namespace App\Controllers;

use App\Lib\Csrf;
use App\Lib\Mailer;
use App\Lib\Pdf;
use App\Lib\RateLimiter;
use App\Lib\Utils;
use App\Models\IntencaoMissa;

class IntencoesController extends BaseController
{
    protected array $publicActions = ['publicoForm','publicoStore'];

    private IntencaoMissa $intencoes;

    public function __construct()
    {
        parent::__construct();
        $this->intencoes = new IntencaoMissa();
    }

    public function publicoForm(): void
    {
        $this->view('intencoes/publico_form', [
            'title' => 'Solicitar Intenção'
        ]);
    }

    public function publicoStore(): void
    {
        if (!RateLimiter::allow('intencao_publica_' . ($_SERVER['REMOTE_ADDR'] ?? 'cli'))) {
            $this->view('intencoes/publico_form', [
                'title' => 'Solicitar Intenção',
                'error' => 'Muitas tentativas. Aguarde.'
            ]);
            return;
        }
        Csrf::validate($_POST['_token'] ?? null);
        $data = $_POST;
        $errors = $this->intencoes->validatePublico($data);
        if ($errors) {
            $this->view('intencoes/publico_form', [
                'title' => 'Solicitar Intenção',
                'errors' => $errors,
                'data' => $data
            ]);
            return;
        }
        $this->intencoes->createPublico($data);
        $this->view('intencoes/publico_sucesso', [
            'title' => 'Solicitação enviada'
        ]);
    }

    public function store(): void
    {
        $this->authorize('intencoes', 'create');
        Csrf::validate($_POST['_token'] ?? null);
        $data = $_POST + ['status' => 'pendente'];
        $data['comprovante_path'] = $data['comprovante_path'] ?? null;
        $this->intencoes->create($data);
        Utils::redirect('intencoes/index');
    }

    public function index(): void
    {
        $this->authorize('intencoes', 'index');
        $filters = [
            'status' => $_GET['status'] ?? '',
            'data' => $_GET['data'] ?? '',
            'ofertante_nome' => $_GET['ofertante_nome'] ?? ''
        ];
        $this->view('intencoes/index', [
            'title' => 'Intenções de Missa',
            'intencoes' => $this->intencoes->all($filters),
            'filters' => $filters
        ]);
    }

    public function approve(): void
    {
        $this->authorize('intencoes', 'approve');
        Csrf::validate($_POST['_token'] ?? null);
        $id = (int) ($_POST['id'] ?? 0);
        $data = [
            'data' => $_POST['data'] ?? '',
            'horario' => $_POST['horario'] ?? '',
            'ofertante_nome' => $_POST['ofertante_nome'] ?? '',
            'ofertante_contato' => $_POST['ofertante_contato'] ?? '',
            'intencao_texto' => $_POST['intencao_texto'] ?? '',
            'valor' => $_POST['valor'] ?? 0,
            'status' => 'confirmada'
        ];
        $this->intencoes->update($id, $data);
        if (!empty($_POST['enviar_email']) && !empty($_POST['email'])) {
            Mailer::send($_POST['email'], $_POST['ofertante_nome'], 'Intenção confirmada', 'Sua intenção foi confirmada.');
        }
        Utils::redirect('intencoes/index');
    }

    public function celebrate(): void
    {
        $this->authorize('intencoes', 'celebrate');
        Csrf::validate($_POST['_token'] ?? null);
        $id = (int) ($_POST['id'] ?? 0);
        $this->intencoes->celebrate($id);
        Utils::redirect('intencoes/index');
    }

    public function uploadComprovante(): void
    {
        $this->authorize('intencoes', 'comprovante');
        $id = (int) ($_POST['id'] ?? 0);
        $file = $_FILES['comprovante'] ?? null;
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $allowed = ['application/pdf', 'image/jpeg', 'image/png'];
            if (in_array($file['type'], $allowed, true) && $file['size'] < 2 * 1024 * 1024) {
                $filename = 'comprovante_' . $id . '_' . basename($file['name']);
                $destPath = dirname(__DIR__, 2) . '/storage/uploads/' . $filename;
                move_uploaded_file($file['tmp_name'], $destPath);
                $this->intencoes->setComprovante($id, 'storage/uploads/' . $filename);
            }
        }
        Utils::redirect('intencoes/index');
    }

    public function reciboPdf(): void
    {
        $this->authorize('intencoes', 'recibo');
        $id = (int) ($_GET['id'] ?? 0);
        $intencao = $this->intencoes->find($id);
        $html = $this->renderPdfView('intencoes/recibo_pdf', ['intencao' => $intencao]);
        Pdf::fromHtml('recibo_intencao_' . $id, $html);
    }

    public function exportCsv(): void
    {
        $this->authorize('intencoes', 'export');
        $rows = $this->intencoes->exportCsv($_GET);
        Utils::csv(['ID', 'Data', 'Horário', 'Ofertante', 'Status', 'Valor'], $rows, 'intencoes.csv');
    }

    public function bulkUpdate(): void
    {
        $this->authorize('intencoes', 'bulk');
        Csrf::validate($_POST['_token'] ?? null);
        $ids = array_map('intval', $_POST['ids'] ?? []);
        $status = $_POST['status'] ?? 'pendente';
        $this->intencoes->bulkUpdate($ids, $status);
        Utils::redirect('intencoes/index');
    }

    private function renderPdfView(string $view, array $data): string
    {
        extract($data);
        ob_start();
        include __DIR__ . '/../views/' . $view . '.php';
        return ob_get_clean();
    }
}
