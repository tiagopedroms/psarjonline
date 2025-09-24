<h1>Pessoas</h1>
<div class="card">
    <form method="get" action="index.php">
        <input type="hidden" name="route" value="pessoas/index">
        <div class="row">
            <div class="col-4">
                <label>Nome</label>
                <input class="form-control" type="text" name="nome" value="<?= htmlspecialchars($filters['nome'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="col-4">
                <label>CPF</label>
                <input class="form-control" type="text" name="cpf" value="<?= htmlspecialchars($filters['cpf'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="col-4">
                <label>Cidade</label>
                <input class="form-control" type="text" name="cidade" value="<?= htmlspecialchars($filters['cidade'] ?? '', ENT_QUOTES) ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <label>UF</label>
                <input class="form-control" type="text" name="uf" value="<?= htmlspecialchars($filters['uf'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="col-4">
                <label>Status</label>
                <input class="form-control" type="text" name="status" value="<?= htmlspecialchars($filters['status'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="col-4 text-end" style="align-self: flex-end;">
                <button class="btn btn-primary" type="submit">Filtrar</button>
                <a class="btn btn-secondary" href="index.php?route=pessoas/create">Nova pessoa</a>
                <a class="btn btn-secondary" href="index.php?route=pessoas/exportCsv">Exportar CSV</a>
            </div>
        </div>
    </form>
</div>
<div class="table-responsive">
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>E-mail</th>
            <th>Cidade</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($pessoas as $pessoa): ?>
        <tr>
            <td><?= (int)$pessoa['id'] ?></td>
            <td><?= htmlspecialchars($pessoa['nome'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($pessoa['cpf'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($pessoa['email'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($pessoa['cidade'], ENT_QUOTES) ?></td>
            <td class="table-actions">
                <a class="btn btn-secondary" href="index.php?route=pessoas/edit&id=<?= (int)$pessoa['id'] ?>">Editar</a>
                <form method="post" action="index.php?route=pessoas/destroy">
                    <?= App\Lib\Csrf::input(); ?>
                    <input type="hidden" name="id" value="<?= (int)$pessoa['id'] ?>">
                    <button class="btn btn-primary" data-confirm="Remover esta pessoa?" type="submit">Excluir</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
