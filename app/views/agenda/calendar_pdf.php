<h1 style="text-align:center;">Agenda Mensal</h1>
<table border="1" cellpadding="4" cellspacing="0" width="100%">
    <tr><th>Data</th><th>Título</th><th>Tipo</th><th>Local</th></tr>
    <?php foreach ($eventos as $evento): ?>
        <tr>
            <td><?= htmlspecialchars($evento['data_inicio'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($evento['titulo'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($evento['tipo'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($evento['local'], ENT_QUOTES) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
