<h1>Sacramentos</h1>
<div class="card">
    <a class="btn btn-primary" href="index.php?route=sacramentos/create">Novo</a>
    <a class="btn btn-secondary" href="index.php?route=sacramentos/exportCsv">Exportar CSV</a>
</div>
<div class="table-responsive">
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Pessoa</th>
            <th>Data</th>
            <th>Livro/Folha/Termo</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($registros as $registro): ?>
        <tr>
            <td><?= (int)$registro['id'] ?></td>
            <td><?= htmlspecialchars($registro['tipo'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($registro['pessoa_nome'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($registro['data'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($registro['livro'] . '/' . $registro['folha'] . '/' . $registro['termo'], ENT_QUOTES) ?></td>
            <td class="table-actions">
                <a class="btn btn-secondary" href="index.php?route=sacramentos/edit&id=<?= (int)$registro['id'] ?>">Editar</a>
                <a class="btn btn-secondary" href="index.php?route=sacramentos/certidaoPdf&id=<?= (int)$registro['id'] ?>" target="_blank">Certidão</a>
                <form method="post" action="index.php?route=sacramentos/destroy">
                    <?= App\Lib\Csrf::input(); ?>
                    <input type="hidden" name="id" value="<?= (int)$registro['id'] ?>">
                    <button class="btn btn-primary" data-confirm="Excluir registro?" type="submit">Excluir</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
