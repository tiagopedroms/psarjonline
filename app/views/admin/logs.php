<h1>Auditoria</h1>
<table class="table">
    <thead><tr><th>Data</th><th>Usuário</th><th>Ação</th><th>Tabela</th><th>Registro</th><th>Detalhes</th></tr></thead>
    <tbody>
    <?php foreach ($logs as $log): ?>
        <tr>
            <td><?= htmlspecialchars($log['criado_em'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($log['usuario_nome'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($log['acao'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($log['tabela'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($log['registro_id'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($log['detalhes'], ENT_QUOTES) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<a class="btn btn-secondary" href="index.php?route=admin/logsExportCsv">Exportar CSV</a>
