<h1><?= $lancamento ? 'Editar' : 'Novo' ?> lançamento</h1>
<form method="post" action="index.php?route=financeiro/<?= $lancamento ? 'update' : 'store' ?>">
    <?= App\Lib\Csrf::input(); ?>
    <?php if ($lancamento): ?>
        <input type="hidden" name="id" value="<?= (int)$lancamento['id'] ?>">
    <?php endif; ?>
    <div class="form-group">
        <label>Data</label>
        <input class="form-control" type="date" name="data" value="<?= htmlspecialchars($lancamento['data'] ?? date('Y-m-d'), ENT_QUOTES) ?>" required>
    </div>
    <div class="form-group">
        <label>Tipo</label>
        <select class="form-control" name="tipo">
            <option value="entrada" <?= (($lancamento['tipo'] ?? '') === 'entrada') ? 'selected' : '' ?>>Entrada</option>
            <option value="saida" <?= (($lancamento['tipo'] ?? '') === 'saida') ? 'selected' : '' ?>>Saída</option>
        </select>
    </div>
    <div class="form-group">
        <label>Categoria</label>
        <input class="form-control" type="text" name="categoria" value="<?= htmlspecialchars($lancamento['categoria'] ?? '', ENT_QUOTES) ?>" required>
    </div>
    <div class="form-group">
        <label>Descrição</label>
        <textarea class="form-control" name="descricao"><?= htmlspecialchars($lancamento['descricao'] ?? '', ENT_QUOTES) ?></textarea>
    </div>
    <div class="form-group">
        <label>Valor</label>
        <input class="form-control" type="number" step="0.01" name="valor" value="<?= htmlspecialchars($lancamento['valor'] ?? '', ENT_QUOTES) ?>" required>
    </div>
    <div class="form-group">
        <label>Pessoa ID</label>
        <input class="form-control" type="number" name="pessoa_id" value="<?= htmlspecialchars($lancamento['pessoa_id'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="form-group">
        <label>Referência</label>
        <input class="form-control" type="text" name="referencia" value="<?= htmlspecialchars($lancamento['referencia'] ?? '', ENT_QUOTES) ?>">
    </div>
    <button class="btn btn-primary" type="submit">Salvar</button>
</form>
