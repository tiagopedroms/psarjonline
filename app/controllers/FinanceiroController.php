<?php

namespace App\Controllers;

use App\Lib\Csrf;
use App\Lib\Pdf;
use App\Lib\Utils;
use App\Models\Lancamento;

class FinanceiroController extends BaseController
{
    private Lancamento $lancamentos;

    public function __construct()
    {
        parent::__construct();
        $this->lancamentos = new Lancamento();
    }

    public function index(): void
    {
        $this->authorize('financeiro', 'index');
        $filters = [
            'tipo' => $_GET['tipo'] ?? '',
            'categoria' => $_GET['categoria'] ?? '',
            'periodo_inicio' => $_GET['periodo_inicio'] ?? '',
            'periodo_fim' => $_GET['periodo_fim'] ?? ''
        ];
        $this->view('financeiro/index', [
            'title' => 'Lançamentos Financeiros',
            'lancamentos' => $this->lancamentos->search($filters),
            'filters' => $filters
        ]);
    }

    public function create(): void
    {
        $this->authorize('financeiro', 'create');
        $this->view('financeiro/form', [
            'title' => 'Novo Lançamento',
            'lancamento' => null
        ]);
    }

    public function store(): void
    {
        $this->authorize('financeiro', 'create');
        Csrf::validate($_POST['_token'] ?? null);
        $this->lancamentos->create($_POST);
        Utils::redirect('financeiro/index');
    }

    public function edit(): void
    {
        $this->authorize('financeiro', 'edit');
        $id = (int) ($_GET['id'] ?? 0);
        $lancamentos = $this->lancamentos->search(['id' => $id]);
        $lancamento = $lancamentos[0] ?? null;
        $this->view('financeiro/form', [
            'title' => 'Editar Lançamento',
            'lancamento' => $lancamento
        ]);
    }

    public function update(): void
    {
        $this->authorize('financeiro', 'edit');
        Csrf::validate($_POST['_token'] ?? null);
        $id = (int) ($_POST['id'] ?? 0);
        $this->lancamentos->update($id, $_POST);
        Utils::redirect('financeiro/index');
    }

    public function destroy(): void
    {
        $this->authorize('financeiro', 'destroy');
        Csrf::validate($_POST['_token'] ?? null);
        $id = (int) ($_POST['id'] ?? 0);
        $this->lancamentos->delete($id);
        Utils::redirect('financeiro/index');
    }

    public function resumoMensal(): void
    {
        $this->authorize('financeiro', 'resumo');
        $inicio = $_GET['inicio'] ?? date('Y-m-01');
        $fim = $_GET['fim'] ?? date('Y-m-t');
        $this->view('financeiro/resumo', [
            'title' => 'Resumo Mensal',
            'resumo' => $this->lancamentos->sumarizar($inicio, $fim),
            'categorias' => $this->lancamentos->porCategoria($inicio, $fim),
            'inicio' => $inicio,
            'fim' => $fim
        ]);
    }

    public function relatorioMensalPdf(): void
    {
        $this->authorize('financeiro', 'relatorio');
        $inicio = $_GET['inicio'] ?? date('Y-m-01');
        $fim = $_GET['fim'] ?? date('Y-m-t');
        $html = $this->renderPdfView('financeiro/relatorio_pdf', [
            'resumo' => $this->lancamentos->sumarizar($inicio, $fim),
            'categorias' => $this->lancamentos->porCategoria($inicio, $fim),
            'inicio' => $inicio,
            'fim' => $fim
        ]);
        Pdf::fromHtml('financeiro_mensal', $html);
    }

    public function exportCsv(): void
    {
        $this->authorize('financeiro', 'export');
        $lancamentos = $this->lancamentos->search($_GET);
        $rows = [];
        foreach ($lancamentos as $lancamento) {
            $rows[] = [
                $lancamento['id'],
                $lancamento['data'],
                $lancamento['tipo'],
                $lancamento['categoria'],
                $lancamento['descricao'],
                $lancamento['valor']
            ];
        }
        Utils::csv(['ID', 'Data', 'Tipo', 'Categoria', 'Descrição', 'Valor'], $rows, 'financeiro.csv');
    }

    private function renderPdfView(string $view, array $data): string
    {
        extract($data);
        ob_start();
        include __DIR__ . '/../views/' . $view . '.php';
        return ob_get_clean();
    }
}
