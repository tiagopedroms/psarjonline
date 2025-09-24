<h1>Calendário</h1>
<div class="card">
    <table class="table">
        <thead>
            <tr><th>Data</th><th>Título</th><th>Tipo</th><th>Local</th></tr>
        </thead>
        <tbody>
        <?php foreach ($eventos as $evento): ?>
            <tr>
                <td><?= htmlspecialchars($evento['data_inicio'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($evento['titulo'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($evento['tipo'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($evento['local'], ENT_QUOTES) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<a class="btn btn-secondary" href="index.php?route=agenda/pdfMensal">Gerar PDF</a>
