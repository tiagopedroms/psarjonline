<?php

namespace App\Controllers;

use App\Lib\Auth;
use App\Lib\Csrf;
use App\Lib\Utils;
use App\Models\Auditoria as AuditoriaModel;
use App\Models\Parametro;
use App\Models\Permissao;
use App\Models\Usuario;

class AdminController extends BaseController
{
    private Usuario $usuarios;
    private Permissao $permissoes;
    private Parametro $parametros;
    private AuditoriaModel $auditoria;

    public function __construct()
    {
        parent::__construct();
        $this->usuarios = new Usuario();
        $this->permissoes = new Permissao();
        $this->parametros = new Parametro();
        $this->auditoria = new AuditoriaModel();
    }

    public function usuariosIndex(): void
    {
        $this->authorize('admin', 'usuarios');
        $this->view('admin/usuarios', [
            'title' => 'Usuários',
            'usuarios' => $this->usuarios->all()
        ]);
    }

    public function usuariosCreate(): void
    {
        $this->authorize('admin', 'usuarios');
        $this->view('admin/usuario_form', [
            'title' => 'Novo usuário',
            'usuario' => null
        ]);
    }

    public function usuariosStore(): void
    {
        $this->authorize('admin', 'usuarios');
        Csrf::validate($_POST['_token'] ?? null);
        $senhaHash = password_hash($_POST['senha'] ?? '123456', PASSWORD_BCRYPT);
        $this->usuarios->create([
            'nome' => $_POST['nome'] ?? '',
            'email' => $_POST['email'] ?? '',
            'senha_hash' => $senhaHash,
            'perfil' => $_POST['perfil'] ?? 'Secretaria',
            'ativo' => isset($_POST['ativo']) ? 1 : 0
        ]);
        Utils::redirect('admin/usuariosIndex');
    }

    public function usuariosEdit(): void
    {
        $this->authorize('admin', 'usuarios');
        $id = (int) ($_GET['id'] ?? 0);
        $usuario = $this->usuarios->find($id);
        $this->view('admin/usuario_form', [
            'title' => 'Editar usuário',
            'usuario' => $usuario
        ]);
    }

    public function usuariosUpdate(): void
    {
        $this->authorize('admin', 'usuarios');
        Csrf::validate($_POST['_token'] ?? null);
        $id = (int) ($_POST['id'] ?? 0);
        $this->usuarios->update($id, [
            'nome' => $_POST['nome'] ?? '',
            'email' => $_POST['email'] ?? '',
            'perfil' => $_POST['perfil'] ?? 'Secretaria',
            'ativo' => isset($_POST['ativo']) ? 1 : 0
        ]);
        Utils::redirect('admin/usuariosIndex');
    }

    public function usuariosReset(): void
    {
        $this->authorize('admin', 'usuarios');
        Csrf::validate($_POST['_token'] ?? null);
        $id = (int) ($_POST['id'] ?? 0);
        $novaSenha = password_hash($_POST['nova_senha'] ?? '123456', PASSWORD_BCRYPT);
        $this->usuarios->resetSenha($id, $novaSenha);
        Utils::redirect('admin/usuariosIndex');
    }

    public function usuariosToggle(): void
    {
        $this->authorize('admin', 'usuarios');
        $id = (int) ($_GET['id'] ?? 0);
        $this->usuarios->toggleAtivo($id);
        Utils::redirect('admin/usuariosIndex');
    }

    public function permissoesIndex(): void
    {
        $this->authorize('admin', 'permissoes');
        $this->view('admin/permissoes', [
            'title' => 'Permissões',
            'matriz' => $this->permissoes->matriz()
        ]);
    }

    public function permissoesUpdate(): void
    {
        $this->authorize('admin', 'permissoes');
        Csrf::validate($_POST['_token'] ?? null);
        $perfil = $_POST['perfil'] ?? '';
        $permissoes = $_POST['permissoes'] ?? [];
        $this->permissoes->updatePerfil($perfil, $permissoes);
        Utils::redirect('admin/permissoesIndex');
    }

    public function parametrosIndex(): void
    {
        $this->authorize('admin', 'parametros');
        $this->view('admin/parametros', [
            'title' => 'Parâmetros',
            'parametros' => $this->parametros->getAll()
        ]);
    }

    public function parametrosSave(): void
    {
        $this->authorize('admin', 'parametros');
        Csrf::validate($_POST['_token'] ?? null);
        foreach ($_POST['parametros'] ?? [] as $chave => $valor) {
            $this->parametros->setValue($chave, $valor);
        }
        Utils::redirect('admin/parametrosIndex');
    }

    public function logsIndex(): void
    {
        $this->authorize('admin', 'auditoria');
        $filters = [
            'usuario_id' => $_GET['usuario_id'] ?? null,
            'modulo' => $_GET['modulo'] ?? null,
            'inicio' => $_GET['inicio'] ?? null,
            'fim' => $_GET['fim'] ?? null
        ];
        $this->view('admin/logs', [
            'title' => 'Logs',
            'logs' => $this->auditoria->list($filters)
        ]);
    }

    public function logsExportCsv(): void
    {
        $this->authorize('admin', 'auditoria');
        $logs = $this->auditoria->list($_GET);
        $rows = [];
        foreach ($logs as $log) {
            $rows[] = [$log['criado_em'], $log['usuario_nome'], $log['acao'], $log['tabela'], $log['registro_id'], $log['detalhes']];
        }
        Utils::csv(['Data', 'Usuário', 'Ação', 'Tabela', 'Registro', 'Detalhes'], $rows, 'auditoria.csv');
    }

    public function backupsIndex(): void
    {
        $this->authorize('admin', 'backups');
        $files = glob(__DIR__ . '/../../storage/backups/*.sql');
        $lista = array_map('basename', $files ?: []);
        $this->view('admin/backups', [
            'title' => 'Backups',
            'backups' => $lista
        ]);
    }

    public function backupsRun(): void
    {
        $this->authorize('admin', 'backups');
        Csrf::validate($_POST['_token'] ?? null);
        exec('php ' . escapeshellarg(__DIR__ . '/../../bin/backup.php'));
        Utils::redirect('admin/backupsIndex');
    }

    public function backupsDownload(): void
    {
        $this->authorize('admin', 'backups');
        $file = basename($_GET['file'] ?? '');
        $path = __DIR__ . '/../../storage/backups/' . $file;
        if (!file_exists($path)) {
            http_response_code(404);
            echo 'Arquivo não encontrado';
            return;
        }
        header('Content-Type: application/sql');
        header('Content-Disposition: attachment; filename=' . $file);
        readfile($path);
        exit;
    }

    public function templatesIndex(): void
    {
        $this->authorize('admin', 'templates');
        $parametros = $this->parametros->getAll();
        $templates = [
            'certidao' => $parametros['template_certidao'] ?? '',
            'recibo' => $parametros['template_recibo'] ?? '',
            'relatorio' => $parametros['template_relatorio'] ?? ''
        ];
        $this->view('admin/templates', [
            'title' => 'Templates PDF',
            'templates' => $templates
        ]);
    }

    public function templatesSave(): void
    {
        $this->authorize('admin', 'templates');
        Csrf::validate($_POST['_token'] ?? null);
        $this->parametros->setValue('template_certidao', $_POST['template_certidao'] ?? '');
        $this->parametros->setValue('template_recibo', $_POST['template_recibo'] ?? '');
        $this->parametros->setValue('template_relatorio', $_POST['template_relatorio'] ?? '');
        Utils::redirect('admin/templatesIndex');
    }
}
