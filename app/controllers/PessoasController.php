<?php

namespace App\Controllers;

use App\Lib\Auth;
use App\Lib\Csrf;
use App\Lib\Mailer;
use App\Lib\Pdf;
use App\Lib\Utils;
use App\Models\Pessoa;

class PessoasController extends BaseController
{
    private Pessoa $pessoas;

    public function __construct()
    {
        parent::__construct();
        $this->pessoas = new Pessoa();
    }

    public function index(): void
    {
        $this->authorize('pessoas', 'index');
        $filters = [
            'nome' => $_GET['nome'] ?? '',
            'cpf' => $_GET['cpf'] ?? '',
            'cidade' => $_GET['cidade'] ?? '',
            'uf' => $_GET['uf'] ?? '',
            'status' => $_GET['status'] ?? ''
        ];
        $this->view('pessoas/index', [
            'title' => 'Pessoas',
            'pessoas' => $this->pessoas->search($filters),
            'filters' => $filters
        ]);
    }

    public function create(): void
    {
        $this->authorize('pessoas', 'create');
        $this->view('pessoas/form', [
            'title' => 'Nova Pessoa',
            'pessoa' => null
        ]);
    }

    public function store(): void
    {
        $this->authorize('pessoas', 'create');
        Csrf::validate($_POST['_token'] ?? null);
        $data = $_POST;
        $errors = $this->pessoas->validate($data);
        if ($errors) {
            $this->view('pessoas/form', [
                'title' => 'Nova Pessoa',
                'pessoa' => $data,
                'errors' => $errors
            ]);
            return;
        }
        $this->pessoas->create($data);
        Utils::redirect('pessoas/index');
    }

    public function edit(): void
    {
        $this->authorize('pessoas', 'edit');
        $id = (int) ($_GET['id'] ?? 0);
        $pessoa = $this->pessoas->find($id);
        $this->view('pessoas/form', [
            'title' => 'Editar Pessoa',
            'pessoa' => $pessoa
        ]);
    }

    public function update(): void
    {
        $this->authorize('pessoas', 'edit');
        Csrf::validate($_POST['_token'] ?? null);
        $id = (int) ($_POST['id'] ?? 0);
        $data = $_POST;
        $errors = $this->pessoas->validate($data);
        if ($errors) {
            $data['id'] = $id;
            $this->view('pessoas/form', [
                'title' => 'Editar Pessoa',
                'pessoa' => $data,
                'errors' => $errors
            ]);
            return;
        }
        $this->pessoas->update($id, $data);
        Utils::redirect('pessoas/index');
    }

    public function destroy(): void
    {
        $this->authorize('pessoas', 'destroy');
        Csrf::validate($_POST['_token'] ?? null);
        $id = (int) ($_POST['id'] ?? 0);
        $this->pessoas->delete($id);
        Utils::redirect('pessoas/index');
    }

    public function merge(): void
    {
        $this->authorize('pessoas', 'merge');
        Csrf::validate($_POST['_token'] ?? null);
        $ids = $_POST['ids'] ?? [];
        $this->pessoas->merge(array_map('intval', $ids));
        Utils::redirect('pessoas/index');
    }

    public function exportCsv(): void
    {
        $this->authorize('pessoas', 'export');
        $filters = $_GET;
        $pessoas = $this->pessoas->search($filters);
        $rows = [];
        foreach ($pessoas as $pessoa) {
            $rows[] = [
                $pessoa['id'],
                $pessoa['nome'],
                $pessoa['cpf'],
                $pessoa['email'],
                $pessoa['cidade'],
                $pessoa['uf']
            ];
        }
        Utils::csv(['ID', 'Nome', 'CPF', 'E-mail', 'Cidade', 'UF'], $rows, 'pessoas.csv');
    }

    public function importCsvPreview(): void
    {
        $this->authorize('pessoas', 'import');
        $file = $_FILES['arquivo'] ?? null;
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            $this->view('pessoas/import', [
                'title' => 'Importar CSV',
                'error' => 'Arquivo inválido'
            ]);
            return;
        }
        $handle = fopen($file['tmp_name'], 'r');
        $rows = [];
        while (($data = fgetcsv($handle, 0, ';')) !== false) {
            $rows[] = $data;
        }
        fclose($handle);
        $preview = array_slice($rows, 0, 5);
        $this->view('pessoas/import', [
            'title' => 'Importar CSV',
            'preview' => $preview,
            'rows' => $rows
        ]);
    }

    public function importCsvCommit(): void
    {
        $this->authorize('pessoas', 'import');
        Csrf::validate($_POST['_token'] ?? null);
        $rows = json_decode($_POST['rows'] ?? '[]', true);
        foreach ($rows as $row) {
            [$nome, $cpf, $email] = array_pad($row, 3, null);
            if ($cpf && !$this->pessoas->findByCpf($cpf)) {
                $this->pessoas->create([
                    'nome' => $nome,
                    'cpf' => $cpf,
                    'email' => $email
                ]);
            }
        }
        Utils::redirect('pessoas/index');
    }

    public function sendEmail(): void
    {
        $this->authorize('pessoas', 'email');
        Csrf::validate($_POST['_token'] ?? null);
        $id = (int) ($_POST['id'] ?? 0);
        $pessoa = $this->pessoas->find($id);
        if ($pessoa && $pessoa['email']) {
            Mailer::send($pessoa['email'], $pessoa['nome'], $_POST['assunto'] ?? 'Mensagem da Paróquia', $_POST['mensagem'] ?? '');
        }
        Utils::redirect('pessoas/index');
    }

    public function history(): void
    {
        $this->authorize('pessoas', 'history');
        $id = (int) ($_GET['id'] ?? 0);
        $pessoa = $this->pessoas->find($id);
        $this->view('pessoas/show', [
            'title' => 'Histórico da Pessoa',
            'pessoa' => $pessoa
        ]);
    }
}
