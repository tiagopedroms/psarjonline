<h1>Resumo Financeiro</h1>
<p>Período: <?= htmlspecialchars($inicio, ENT_QUOTES) ?> a <?= htmlspecialchars($fim, ENT_QUOTES) ?></p>
<div class="row">
    <div class="col-4"><div class="card"><h3>Entradas</h3><p>R$ <?= number_format((float)$resumo['entrada'], 2, ',', '.') ?></p></div></div>
    <div class="col-4"><div class="card"><h3>Saídas</h3><p>R$ <?= number_format((float)$resumo['saida'], 2, ',', '.') ?></p></div></div>
    <div class="col-4"><div class="card"><h3>Saldo</h3><p>R$ <?= number_format((float)$resumo['saldo'], 2, ',', '.') ?></p></div></div>
</div>
<h2>Por categoria</h2>
<table class="table">
    <thead><tr><th>Categoria</th><th>Total</th></tr></thead>
    <tbody>
    <?php foreach ($categorias as $categoria): ?>
        <tr>
            <td><?= htmlspecialchars($categoria['categoria'], ENT_QUOTES) ?></td>
            <td>R$ <?= number_format((float)$categoria['total'], 2, ',', '.') ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<a class="btn btn-secondary" href="index.php?route=financeiro/relatorioMensalPdf&inicio=<?= urlencode($inicio) ?>&fim=<?= urlencode($fim) ?>">Gerar PDF</a>
