<h1 style="text-align:center;">Relatório Financeiro</h1>
<p>Período: <?= htmlspecialchars($inicio, ENT_QUOTES) ?> a <?= htmlspecialchars($fim, ENT_QUOTES) ?></p>
<p>Entradas: R$ <?= number_format((float)$resumo['entrada'], 2, ',', '.') ?> | Saídas: R$ <?= number_format((float)$resumo['saida'], 2, ',', '.') ?> | Saldo: R$ <?= number_format((float)$resumo['saldo'], 2, ',', '.') ?></p>
<table border="1" cellpadding="4" cellspacing="0" width="100%">
    <tr><th>Categoria</th><th>Total</th></tr>
    <?php foreach ($categorias as $categoria): ?>
        <tr>
            <td><?= htmlspecialchars($categoria['categoria'], ENT_QUOTES) ?></td>
            <td>R$ <?= number_format((float)$categoria['total'], 2, ',', '.') ?></td>
        </tr>
    <?php endforeach; ?>
</table>
