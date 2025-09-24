<h1><?= $evento ? 'Editar' : 'Novo' ?> Evento</h1>
<form method="post" action="index.php?route=agenda/<?= $evento ? 'update' : 'store' ?>">
    <?= App\Lib\Csrf::input(); ?>
    <?php if ($evento): ?>
        <input type="hidden" name="id" value="<?= (int)$evento['id'] ?>">
    <?php endif; ?>
    <div class="form-group">
        <label>Título</label>
        <input class="form-control" type="text" name="titulo" value="<?= htmlspecialchars($evento['titulo'] ?? '', ENT_QUOTES) ?>" required>
    </div>
    <div class="form-group">
        <label>Tipo</label>
        <select class="form-control" name="tipo">
            <?php foreach (['missa','encontro','reuniao','catequese'] as $tipo): ?>
                <option value="<?= $tipo ?>" <?= (($evento['tipo'] ?? '') === $tipo) ? 'selected' : '' ?>><?= ucfirst($tipo) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>Descrição</label>
        <textarea class="form-control" name="descricao"><?= htmlspecialchars($evento['descricao'] ?? '', ENT_QUOTES) ?></textarea>
    </div>
    <div class="form-group">
        <label>Data início</label>
        <input class="form-control" type="datetime-local" name="data_inicio" value="<?= htmlspecialchars($evento['data_inicio'] ?? '', ENT_QUOTES) ?>" required>
    </div>
    <div class="form-group">
        <label>Data fim</label>
        <input class="form-control" type="datetime-local" name="data_fim" value="<?= htmlspecialchars($evento['data_fim'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="form-group">
        <label>Local</label>
        <input class="form-control" type="text" name="local" value="<?= htmlspecialchars($evento['local'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="form-group">
        <label>Responsável</label>
        <input class="form-control" type="text" name="responsavel" value="<?= htmlspecialchars($evento['responsavel'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="form-group">
        <label>Publicado?</label>
        <select class="form-control" name="publicado">
            <option value="0" <?= empty($evento['publicado']) ? 'selected' : '' ?>>Não</option>
            <option value="1" <?= !empty($evento['publicado']) ? 'selected' : '' ?>>Sim</option>
        </select>
    </div>
    <button class="btn btn-primary" type="submit">Salvar</button>
</form>
