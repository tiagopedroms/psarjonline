<?php

namespace App\Controllers;

use App\Lib\Csrf;
use App\Lib\Pdf;
use App\Lib\Utils;
use App\Models\Evento;

class AgendaController extends BaseController
{
    private Evento $eventos;

    public function __construct()
    {
        parent::__construct();
        $this->eventos = new Evento();
    }

    public function index(): void
    {
        $this->authorize('agenda', 'index');
        $filters = [
            'tipo' => $_GET['tipo'] ?? '',
            'periodo_inicio' => $_GET['periodo_inicio'] ?? '',
            'periodo_fim' => $_GET['periodo_fim'] ?? ''
        ];
        $this->view('agenda/index', [
            'title' => 'Agenda',
            'eventos' => $this->eventos->search($filters),
            'filters' => $filters
        ]);
    }

    public function create(): void
    {
        $this->authorize('agenda', 'create');
        $this->view('agenda/form', [
            'title' => 'Novo Evento',
            'evento' => null
        ]);
    }

    public function store(): void
    {
        $this->authorize('agenda', 'create');
        Csrf::validate($_POST['_token'] ?? null);
        $data = $_POST;
        $this->eventos->create($data);
        Utils::redirect('agenda/index');
    }

    public function edit(): void
    {
        $this->authorize('agenda', 'edit');
        $id = (int) ($_GET['id'] ?? 0);
        $evento = $this->eventos->find($id);
        $this->view('agenda/form', [
            'title' => 'Editar Evento',
            'evento' => $evento
        ]);
    }

    public function update(): void
    {
        $this->authorize('agenda', 'edit');
        Csrf::validate($_POST['_token'] ?? null);
        $id = (int) ($_POST['id'] ?? 0);
        $data = $_POST;
        $this->eventos->update($id, $data);
        Utils::redirect('agenda/index');
    }

    public function destroy(): void
    {
        $this->authorize('agenda', 'destroy');
        Csrf::validate($_POST['_token'] ?? null);
        $id = (int) ($_POST['id'] ?? 0);
        $this->eventos->delete($id);
        Utils::redirect('agenda/index');
    }

    public function ics(): void
    {
        $this->authorize('agenda', 'ics');
        $id = (int) ($_GET['id'] ?? 0);
        $evento = $this->eventos->find($id);
        $ics = $this->eventos->toIcs($evento);
        Utils::ics($ics, 'evento_' . $id . '.ics');
    }

    public function exportCsv(): void
    {
        $this->authorize('agenda', 'export');
        $eventos = $this->eventos->search($_GET);
        $rows = [];
        foreach ($eventos as $evento) {
            $rows[] = [
                $evento['id'],
                $evento['tipo'],
                $evento['titulo'],
                $evento['data_inicio'],
                $evento['local'],
                $evento['responsavel']
            ];
        }
        Utils::csv(['ID', 'Tipo', 'Título', 'Início', 'Local', 'Responsável'], $rows, 'agenda.csv');
    }

    public function publicarToggle(): void
    {
        $this->authorize('agenda', 'publicar');
        $id = (int) ($_GET['id'] ?? 0);
        $evento = $this->eventos->find($id);
        $evento['publicado'] = $evento['publicado'] ? 0 : 1;
        $this->eventos->update($id, $evento);
        Utils::redirect('agenda/index');
    }

    public function viewCalendar(): void
    {
        $this->authorize('agenda', 'calendar');
        $this->view('agenda/calendar', [
            'title' => 'Calendário',
            'eventos' => $this->eventos->search([])
        ]);
    }

    public function pdfMensal(): void
    {
        $this->authorize('agenda', 'relatorio');
        $filters = [
            'periodo_inicio' => $_GET['periodo_inicio'] ?? date('Y-m-01'),
            'periodo_fim' => $_GET['periodo_fim'] ?? date('Y-m-t')
        ];
        $eventos = $this->eventos->search($filters);
        $html = $this->renderPdfView('agenda/calendar_pdf', ['eventos' => $eventos, 'filters' => $filters]);
        Pdf::fromHtml('agenda_mensal', $html);
    }

    private function renderPdfView(string $view, array $data): string
    {
        extract($data);
        ob_start();
        include __DIR__ . '/../views/' . $view . '.php';
        return ob_get_clean();
    }
}
