<h1>Horários de Missa</h1>
<?php if ($conteudo): ?>
    <div class="card">
        <?= $conteudo ?>
    </div>
<?php else: ?>
    <table class="table">
        <thead><tr><th>Data</th><th>Título</th><th>Local</th></tr></thead>
        <tbody>
        <?php foreach ($eventos as $evento): ?>
            <tr>
                <td><?= htmlspecialchars($evento['data_inicio'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($evento['titulo'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($evento['local'], ENT_QUOTES) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
