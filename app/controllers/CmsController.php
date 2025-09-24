<?php

namespace App\Controllers;

use App\Lib\Csrf;
use App\Lib\Utils;
use App\Models\Evento;
use App\Models\Pagina;

class CmsController extends BaseController
{
    protected array $publicActions = ['publicNoticias','publicHorarios'];

    private Pagina $paginas;
    private Evento $eventos;

    public function __construct()
    {
        parent::__construct();
        $this->paginas = new Pagina();
        $this->eventos = new Evento();
    }

    public function paginasIndex(): void
    {
        $this->authorize('cms', 'paginas');
        $this->view('cms/paginas', [
            'title' => 'Páginas',
            'paginas' => $this->paginas->all()
        ]);
    }

    public function create(): void
    {
        $this->authorize('cms', 'paginas');
        $this->view('cms/pagina_form', [
            'title' => 'Nova Página',
            'pagina' => null
        ]);
    }

    public function store(): void
    {
        $this->authorize('cms', 'paginas');
        Csrf::validate($_POST['_token'] ?? null);
        $this->paginas->create($_POST);
        Utils::redirect('cms/paginasIndex');
    }

    public function edit(): void
    {
        $this->authorize('cms', 'paginas');
        $id = (int) ($_GET['id'] ?? 0);
        $pagina = $this->paginas->find($id);
        $this->view('cms/pagina_form', [
            'title' => 'Editar Página',
            'pagina' => $pagina
        ]);
    }

    public function update(): void
    {
        $this->authorize('cms', 'paginas');
        Csrf::validate($_POST['_token'] ?? null);
        $id = (int) ($_POST['id'] ?? 0);
        $this->paginas->update($id, $_POST);
        Utils::redirect('cms/paginasIndex');
    }

    public function destroy(): void
    {
        $this->authorize('cms', 'paginas');
        Csrf::validate($_POST['_token'] ?? null);
        $id = (int) ($_POST['id'] ?? 0);
        $this->paginas->delete($id);
        Utils::redirect('cms/paginasIndex');
    }

    public function preview(): void
    {
        $this->authorize('cms', 'paginas');
        $conteudo = Utils::sanitizeHtml($_POST['conteudo_html'] ?? '');
        $this->view('cms/preview', [
            'title' => 'Pré-visualização',
            'conteudo' => $conteudo
        ]);
    }

    public function publicNoticias(): void
    {
        $this->requiresAuth = false;
        $paginas = $this->paginas->published();
        $this->view('cms/public_noticias', [
            'title' => 'Notícias',
            'paginas' => $paginas
        ]);
    }

    public function publicHorarios(): void
    {
        $this->requiresAuth = false;
        $pagina = $this->paginas->findBySlug('horarios');
        if (!$pagina) {
            $eventos = $this->eventos->search(['tipo' => 'missa', 'publicado' => 1]);
            $this->view('cms/public_horarios', [
                'title' => 'Horários de Missa',
                'eventos' => $eventos,
                'conteudo' => null
            ]);
            return;
        }
        $this->view('cms/public_horarios', [
            'title' => 'Horários de Missa',
            'eventos' => [],
            'conteudo' => $pagina['conteudo_html']
        ]);
    }
}
