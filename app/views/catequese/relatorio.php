<h1>Relatório de Presença - <?= htmlspecialchars($turma['nome'] ?? '', ENT_QUOTES) ?></h1>
<p>Período: <?= htmlspecialchars($inicio, ENT_QUOTES) ?> a <?= htmlspecialchars($fim, ENT_QUOTES) ?></p>
<table border="1" cellpadding="4" cellspacing="0" width="100%">
    <tr><th>Data</th><th>Aluno</th><th>Presente</th></tr>
    <?php foreach ($registros as $registro): ?>
        <tr>
            <td><?= htmlspecialchars($registro['data'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($registro['nome'], ENT_QUOTES) ?></td>
            <td><?= $registro['presente'] ? 'Sim' : 'Não' ?></td>
        </tr>
    <?php endforeach; ?>
</table>
