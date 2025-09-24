<h1>Intenções de Missa</h1>
<div class="card">
    <a class="btn btn-primary" href="index.php?route=intencoes/exportCsv">Exportar CSV</a>
</div>
<div class="table-responsive">
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Data</th>
            <th>Horário</th>
            <th>Ofertante</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($intencoes as $intencao): ?>
        <tr>
            <td><?= (int)$intencao['id'] ?></td>
            <td><?= htmlspecialchars($intencao['data'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($intencao['horario'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($intencao['ofertante_nome'], ENT_QUOTES) ?></td>
            <td><span class="badge-status"><?= htmlspecialchars($intencao['status'], ENT_QUOTES) ?></span></td>
            <td class="table-actions">
                <form method="post" action="index.php?route=intencoes/approve">
                    <?= App\Lib\Csrf::input(); ?>
                    <input type="hidden" name="id" value="<?= (int)$intencao['id'] ?>">
                    <input type="hidden" name="data" value="<?= htmlspecialchars($intencao['data'], ENT_QUOTES) ?>">
                    <input type="hidden" name="horario" value="<?= htmlspecialchars($intencao['horario'], ENT_QUOTES) ?>">
                    <input type="hidden" name="ofertante_nome" value="<?= htmlspecialchars($intencao['ofertante_nome'], ENT_QUOTES) ?>">
                    <input type="hidden" name="ofertante_contato" value="<?= htmlspecialchars($intencao['ofertante_contato'], ENT_QUOTES) ?>">
                    <input type="hidden" name="intencao_texto" value="<?= htmlspecialchars($intencao['intencao_texto'], ENT_QUOTES) ?>">
                    <input type="hidden" name="valor" value="<?= htmlspecialchars($intencao['valor'], ENT_QUOTES) ?>">
                    <button class="btn btn-secondary" type="submit">Confirmar</button>
                </form>
                <form method="post" action="index.php?route=intencoes/celebrate">
                    <?= App\Lib\Csrf::input(); ?>
                    <input type="hidden" name="id" value="<?= (int)$intencao['id'] ?>">
                    <button class="btn btn-primary" type="submit">Celebrar</button>
                </form>
                <a class="btn btn-secondary" href="index.php?route=intencoes/reciboPdf&id=<?= (int)$intencao['id'] ?>" target="_blank">Recibo</a>
                <form method="post" enctype="multipart/form-data" action="index.php?route=intencoes/uploadComprovante">
                    <?= App\Lib\Csrf::input(); ?>
                    <input type="hidden" name="id" value="<?= (int)$intencao['id'] ?>">
                    <input type="file" name="comprovante" accept="application/pdf,image/jpeg,image/png" required>
                    <button class="btn btn-secondary" type="submit">Anexar</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
