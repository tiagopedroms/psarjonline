<h1>Lançamentos Financeiros</h1>
<a class="btn btn-primary" href="index.php?route=financeiro/create">Novo lançamento</a>
<div class="table-responsive">
<table class="table">
    <thead><tr><th>ID</th><th>Data</th><th>Tipo</th><th>Categoria</th><th>Descrição</th><th>Valor</th><th>Ações</th></tr></thead>
    <tbody>
    <?php foreach ($lancamentos as $lancamento): ?>
        <tr>
            <td><?= (int)$lancamento['id'] ?></td>
            <td><?= htmlspecialchars($lancamento['data'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($lancamento['tipo'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($lancamento['categoria'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($lancamento['descricao'], ENT_QUOTES) ?></td>
            <td>R$ <?= number_format((float)$lancamento['valor'], 2, ',', '.') ?></td>
            <td class="table-actions">
                <a class="btn btn-secondary" href="index.php?route=financeiro/edit&id=<?= (int)$lancamento['id'] ?>">Editar</a>
                <form method="post" action="index.php?route=financeiro/destroy">
                    <?= App\Lib\Csrf::input(); ?>
                    <input type="hidden" name="id" value="<?= (int)$lancamento['id'] ?>">
                    <button class="btn btn-primary" data-confirm="Excluir lançamento?" type="submit">Excluir</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<a class="btn btn-secondary" href="index.php?route=financeiro/resumoMensal">Resumo mensal</a>
<a class="btn btn-secondary" href="index.php?route=financeiro/exportCsv">Exportar CSV</a>
