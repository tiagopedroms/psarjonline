<h1>Páginas</h1>
<a class="btn btn-primary" href="index.php?route=cms/create">Nova página</a>
<div class="table-responsive">
<table class="table">
    <thead><tr><th>ID</th><th>Slug</th><th>Título</th><th>Publicado</th><th>Ações</th></tr></thead>
    <tbody>
    <?php foreach ($paginas as $pagina): ?>
        <tr>
            <td><?= (int)$pagina['id'] ?></td>
            <td><?= htmlspecialchars($pagina['slug'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($pagina['titulo'], ENT_QUOTES) ?></td>
            <td><?= $pagina['publicado'] ? 'Sim' : 'Não' ?></td>
            <td class="table-actions">
                <a class="btn btn-secondary" href="index.php?route=cms/edit&id=<?= (int)$pagina['id'] ?>">Editar</a>
                <form method="post" action="index.php?route=cms/destroy">
                    <?= App\Lib\Csrf::input(); ?>
                    <input type="hidden" name="id" value="<?= (int)$pagina['id'] ?>">
                    <button class="btn btn-primary" data-confirm="Excluir página?" type="submit">Excluir</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
