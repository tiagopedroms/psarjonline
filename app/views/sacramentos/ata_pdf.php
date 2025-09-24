<h1 style="text-align:center;">Ata de Sacramentos</h1>
<table border="1" cellpadding="4" cellspacing="0" width="100%">
    <tr>
        <th>ID</th><th>Tipo</th><th>Pessoa</th><th>Data</th><th>Livro</th><th>Folha</th><th>Termo</th>
    </tr>
    <?php foreach ($registros as $registro): ?>
    <tr>
        <td><?= (int)$registro['id'] ?></td>
        <td><?= htmlspecialchars($registro['tipo'], ENT_QUOTES) ?></td>
        <td><?= htmlspecialchars($registro['pessoa_nome'], ENT_QUOTES) ?></td>
        <td><?= htmlspecialchars($registro['data'], ENT_QUOTES) ?></td>
        <td><?= htmlspecialchars($registro['livro'], ENT_QUOTES) ?></td>
        <td><?= htmlspecialchars($registro['folha'], ENT_QUOTES) ?></td>
        <td><?= htmlspecialchars($registro['termo'], ENT_QUOTES) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
