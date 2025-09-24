<h1><?= $registro ? 'Editar' : 'Novo' ?> Sacramento</h1>
<form method="post" action="index.php?route=sacramentos/<?= $registro ? 'update' : 'store' ?>">
    <?= App\Lib\Csrf::input(); ?>
    <?php if ($registro): ?>
        <input type="hidden" name="id" value="<?= (int)$registro['id'] ?>">
    <?php endif; ?>
    <div class="form-group">
        <label>Pessoa ID</label>
        <input class="form-control" type="number" name="pessoa_id" value="<?= htmlspecialchars($registro['pessoa_id'] ?? '', ENT_QUOTES) ?>" required>
    </div>
    <div class="form-group">
        <label>Tipo</label>
        <select class="form-control" name="tipo">
            <?php foreach (['batismo','eucaristia','crisma','matrimonio'] as $tipo): ?>
                <option value="<?= $tipo ?>" <?= (($registro['tipo'] ?? '') === $tipo) ? 'selected' : '' ?>><?= ucfirst($tipo) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>Data</label>
        <input class="form-control" type="date" name="data" value="<?= htmlspecialchars($registro['data'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="form-group">
        <label>Livro</label>
        <input class="form-control" type="text" name="livro" value="<?= htmlspecialchars($registro['livro'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="form-group">
        <label>Folha</label>
        <input class="form-control" type="text" name="folha" value="<?= htmlspecialchars($registro['folha'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="form-group">
        <label>Termo</label>
        <input class="form-control" type="text" name="termo" value="<?= htmlspecialchars($registro['termo'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="form-group">
        <label>Celebrante</label>
        <input class="form-control" type="text" name="celebrante" value="<?= htmlspecialchars($registro['celebrante'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="form-group">
        <label>Local</label>
        <input class="form-control" type="text" name="local" value="<?= htmlspecialchars($registro['local'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="form-group">
        <label>Observações</label>
        <textarea class="form-control" name="obs"><?= htmlspecialchars($registro['obs'] ?? '', ENT_QUOTES) ?></textarea>
    </div>
    <?php if (!$registro): ?>
        <label><input type="checkbox" name="auto_numerar" value="1"> Gerar numeração automaticamente</label>
    <?php endif; ?>
    <button class="btn btn-primary" type="submit">Salvar</button>
    <a class="btn btn-secondary" href="index.php?route=sacramentos/index">Voltar</a>
</form>
