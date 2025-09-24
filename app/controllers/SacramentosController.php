<?php

namespace App\Controllers;

use App\Lib\Csrf;
use App\Lib\Pdf;
use App\Lib\Utils;
use App\Models\Pessoa;
use App\Models\Sacramento;

class SacramentosController extends BaseController
{
    protected array $publicActions = ['verificarCodigo'];

    private Sacramento $sacramentos;
    private Pessoa $pessoas;

    public function __construct()
    {
        parent::__construct();
        $this->sacramentos = new Sacramento();
        $this->pessoas = new Pessoa();
    }

    public function index(): void
    {
        $this->authorize('sacramentos', 'index');
        $filters = [
            'tipo' => $_GET['tipo'] ?? '',
            'ano' => $_GET['ano'] ?? '',
            'celebrante' => $_GET['celebrante'] ?? '',
            'livro' => $_GET['livro'] ?? ''
        ];
        $this->view('sacramentos/index', [
            'title' => 'Sacramentos',
            'registros' => $this->sacramentos->search($filters),
            'filters' => $filters
        ]);
    }

    public function create(): void
    {
        $this->authorize('sacramentos', 'create');
        $this->view('sacramentos/form', [
            'title' => 'Novo Sacramento',
            'registro' => null
        ]);
    }

    public function store(): void
    {
        $this->authorize('sacramentos', 'create');
        Csrf::validate($_POST['_token'] ?? null);
        $data = $_POST;
        if (!empty($_POST['auto_numerar'])) {
            $numeracao = $this->sacramentos->numerar($data['tipo']);
            $data = array_merge($data, $numeracao);
        }
        if (empty($data['codigo_verificacao'])) {
            $data['codigo_verificacao'] = $this->sacramentos->gerarCodigoVerificacao();
        }
        $this->sacramentos->create($data);
        Utils::redirect('sacramentos/index');
    }

    public function edit(): void
    {
        $this->authorize('sacramentos', 'edit');
        $id = (int) ($_GET['id'] ?? 0);
        $registro = $this->sacramentos->find($id);
        $this->view('sacramentos/form', [
            'title' => 'Editar Sacramento',
            'registro' => $registro
        ]);
    }

    public function update(): void
    {
        $this->authorize('sacramentos', 'edit');
        Csrf::validate($_POST['_token'] ?? null);
        $id = (int) ($_POST['id'] ?? 0);
        $data = $_POST;
        $this->sacramentos->update($id, $data);
        Utils::redirect('sacramentos/index');
    }

    public function destroy(): void
    {
        $this->authorize('sacramentos', 'destroy');
        Csrf::validate($_POST['_token'] ?? null);
        $id = (int) ($_POST['id'] ?? 0);
        $this->sacramentos->delete($id);
        Utils::redirect('sacramentos/index');
    }

    public function certidaoPdf(): void
    {
        $this->authorize('sacramentos', 'certidao');
        $id = (int) ($_GET['id'] ?? 0);
        $registro = $this->sacramentos->pdfData($id);
        $html = $this->renderPdfView('sacramentos/certidao_pdf', ['registro' => $registro, 'segunda_via' => false]);
        Pdf::fromHtml('certidao_' . $registro['codigo_verificacao'], $html);
    }

    public function segundaViaPdf(): void
    {
        $this->authorize('sacramentos', 'certidao');
        $id = (int) ($_GET['id'] ?? 0);
        $registro = $this->sacramentos->pdfData($id);
        $html = $this->renderPdfView('sacramentos/certidao_pdf', ['registro' => $registro, 'segunda_via' => true]);
        Pdf::fromHtml('certidao_segunda_via_' . $registro['codigo_verificacao'], $html);
    }

    public function ataPdf(): void
    {
        $this->authorize('sacramentos', 'ata');
        $filters = [
            'tipo' => $_GET['tipo'] ?? '',
            'ano' => $_GET['ano'] ?? ''
        ];
        $registros = $this->sacramentos->search($filters);
        $html = $this->renderPdfView('sacramentos/ata_pdf', ['registros' => $registros, 'filters' => $filters]);
        Pdf::fromHtml('ata_sacramentos', $html);
    }

    public function exportCsv(): void
    {
        $this->authorize('sacramentos', 'export');
        $rows = $this->sacramentos->exportCsv($_GET);
        Utils::csv(['ID', 'Tipo', 'Pessoa', 'Data', 'Livro', 'Folha', 'Termo', 'Celebrante'], $rows, 'sacramentos.csv');
    }

    public function verificarCodigo(): void
    {
        $codigo = $_GET['codigo'] ?? '';
        $registro = $this->sacramentos->verificarCodigo($codigo);
        $this->view('sacramentos/consulta_publica', [
            'title' => 'Verificar Certidão',
            'registro' => $registro
        ]);
    }

    private function renderPdfView(string $view, array $data): string
    {
        extract($data);
        ob_start();
        include __DIR__ . '/../views/' . $view . '.php';
        return ob_get_clean();
    }
}
