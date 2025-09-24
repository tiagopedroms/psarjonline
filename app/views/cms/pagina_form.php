<h1><?= $pagina ? 'Editar' : 'Nova' ?> página</h1>
<form method="post" action="index.php?route=cms/<?= $pagina ? 'update' : 'store' ?>">
    <?= App\Lib\Csrf::input(); ?>
    <?php if ($pagina): ?>
        <input type="hidden" name="id" value="<?= (int)$pagina['id'] ?>">
    <?php endif; ?>
    <div class="form-group">
        <label>Slug</label>
        <input class="form-control" type="text" name="slug" value="<?= htmlspecialchars($pagina['slug'] ?? '', ENT_QUOTES) ?>" required>
    </div>
    <div class="form-group">
        <label>Título</label>
        <input class="form-control" type="text" name="titulo" value="<?= htmlspecialchars($pagina['titulo'] ?? '', ENT_QUOTES) ?>" required>
    </div>
    <div class="form-group">
        <label>Conteúdo</label>
        <textarea class="form-control" name="conteudo_html" rows="6"><?= htmlspecialchars($pagina['conteudo_html'] ?? '', ENT_QUOTES) ?></textarea>
    </div>
    <div class="form-group">
        <label>Publicado?</label>
        <select class="form-control" name="publicado">
            <option value="0" <?= empty($pagina['publicado']) ? 'selected' : '' ?>>Não</option>
            <option value="1" <?= !empty($pagina['publicado']) ? 'selected' : '' ?>>Sim</option>
        </select>
    </div>
    <button class="btn btn-primary" type="submit">Salvar</button>
</form>
<form method="post" action="index.php?route=cms/preview" target="_blank" style="margin-top:1rem;">
    <?= App\Lib\Csrf::input(); ?>
    <textarea name="conteudo_html" style="display:none;"><?= htmlspecialchars($pagina['conteudo_html'] ?? '', ENT_QUOTES) ?></textarea>
    <button class="btn btn-secondary" type="submit">Pré-visualizar</button>
</form>
