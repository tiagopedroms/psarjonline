<?php

namespace App\Controllers;

use App\Lib\Csrf;
use App\Lib\Pdf;
use App\Lib\Utils;
use App\Models\CatequeseAluno;
use App\Models\CatequeseTurma;
use App\Models\Pessoa;
use App\Models\Presenca;

class CatequeseController extends BaseController
{
    private CatequeseTurma $turmas;
    private CatequeseAluno $alunos;
    private Presenca $presencas;
    private Pessoa $pessoas;

    public function __construct()
    {
        parent::__construct();
        $this->turmas = new CatequeseTurma();
        $this->alunos = new CatequeseAluno();
        $this->presencas = new Presenca();
        $this->pessoas = new Pessoa();
    }

    public function turmasIndex(): void
    {
        $this->authorize('catequese', 'turmas');
        $this->view('catequese/turmas', [
            'title' => 'Turmas de Catequese',
            'turmas' => $this->turmas->all()
        ]);
    }

    public function turmaCreate(): void
    {
        $this->authorize('catequese', 'turmas');
        $this->view('catequese/turma_form', [
            'title' => 'Nova Turma',
            'turma' => null
        ]);
    }

    public function turmaStore(): void
    {
        $this->authorize('catequese', 'turmas');
        Csrf::validate($_POST['_token'] ?? null);
        $this->turmas->create($_POST);
        Utils::redirect('catequese/turmasIndex');
    }

    public function turmaEdit(): void
    {
        $this->authorize('catequese', 'turmas');
        $id = (int) ($_GET['id'] ?? 0);
        $this->view('catequese/turma_form', [
            'title' => 'Editar Turma',
            'turma' => $this->turmas->find($id)
        ]);
    }

    public function turmaUpdate(): void
    {
        $this->authorize('catequese', 'turmas');
        Csrf::validate($_POST['_token'] ?? null);
        $id = (int) ($_POST['id'] ?? 0);
        $this->turmas->update($id, $_POST);
        Utils::redirect('catequese/turmasIndex');
    }

    public function turmaDestroy(): void
    {
        $this->authorize('catequese', 'turmas');
        Csrf::validate($_POST['_token'] ?? null);
        $id = (int) ($_POST['id'] ?? 0);
        $this->turmas->delete($id);
        Utils::redirect('catequese/turmasIndex');
    }

    public function alunosIndex(): void
    {
        $this->authorize('catequese', 'alunos');
        $turmaId = (int) ($_GET['turma_id'] ?? 0);
        $this->view('catequese/alunos', [
            'title' => 'Alunos',
            'turma' => $this->turmas->find($turmaId),
            'alunos' => $this->alunos->byTurma($turmaId)
        ]);
    }

    public function alunoAdd(): void
    {
        $this->authorize('catequese', 'alunos');
        Csrf::validate($_POST['_token'] ?? null);
        $turmaId = (int) ($_POST['turma_id'] ?? 0);
        $pessoaId = (int) ($_POST['pessoa_id'] ?? 0);
        $this->alunos->add($turmaId, $pessoaId, $_POST['status'] ?? 'ativo');
        Utils::redirect('catequese/alunosIndex&turma_id=' . $turmaId);
    }

    public function alunoRemove(): void
    {
        $this->authorize('catequese', 'alunos');
        Csrf::validate($_POST['_token'] ?? null);
        $this->alunos->remove((int) ($_POST['id'] ?? 0));
        Utils::redirect('catequese/alunosIndex&turma_id=' . ((int) $_POST['turma_id']));
    }

    public function presencaIndex(): void
    {
        $this->authorize('catequese', 'presenca');
        $turmaId = (int) ($_GET['turma_id'] ?? 0);
        $this->view('catequese/presenca', [
            'title' => 'Presença',
            'turma' => $this->turmas->find($turmaId),
            'alunos' => $this->alunos->byTurma($turmaId)
        ]);
    }

    public function presencaStore(): void
    {
        $this->authorize('catequese', 'presenca');
        Csrf::validate($_POST['_token'] ?? null);
        $turmaId = (int) ($_POST['turma_id'] ?? 0);
        $data = $_POST['data'] ?? date('Y-m-d');
        foreach ($_POST['presencas'] ?? [] as $pessoaId => $valor) {
            $this->presencas->registrar($turmaId, (int) $pessoaId, $data, (bool) $valor, '');
        }
        Utils::redirect('catequese/presencaIndex&turma_id=' . $turmaId);
    }

    public function relatorioPresencaPdf(): void
    {
        $this->authorize('catequese', 'relatorio');
        $turmaId = (int) ($_GET['turma_id'] ?? 0);
        $inicio = $_GET['inicio'] ?? date('Y-m-01');
        $fim = $_GET['fim'] ?? date('Y-m-t');
        $registros = $this->presencas->listarPorTurmaEPeriodo($turmaId, $inicio, $fim);
        $html = $this->renderPdfView('catequese/relatorio', [
            'registros' => $registros,
            'turma' => $this->turmas->find($turmaId),
            'inicio' => $inicio,
            'fim' => $fim
        ]);
        Pdf::fromHtml('presenca_turma_' . $turmaId, $html);
    }

    public function exportAlunosCsv(): void
    {
        $this->authorize('catequese', 'export');
        $turmaId = (int) ($_GET['turma_id'] ?? 0);
        $alunos = $this->alunos->byTurma($turmaId);
        $rows = [];
        foreach ($alunos as $aluno) {
            $rows[] = [$aluno['nome'], $aluno['cpf'], $aluno['status']];
        }
        Utils::csv(['Nome', 'CPF', 'Status'], $rows, 'alunos_turma_' . $turmaId . '.csv');
    }

    private function renderPdfView(string $view, array $data): string
    {
        extract($data);
        ob_start();
        include __DIR__ . '/../views/' . $view . '.php';
        return ob_get_clean();
    }
}
