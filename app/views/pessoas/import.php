<h1>Importar Pessoas via CSV</h1>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES) ?></div>
<?php endif; ?>
<?php if (empty($preview)): ?>
<form method="post" enctype="multipart/form-data" action="index.php?route=pessoas/importCsvPreview">
    <?= App\Lib\Csrf::input(); ?>
    <div class="form-group">
        <label>Arquivo CSV</label>
        <input type="file" name="arquivo" required>
    </div>
    <button class="btn btn-primary" type="submit">Pré-visualizar</button>
</form>
<?php else: ?>
    <div class="card">
        <h2>Pré-visualização</h2>
        <table class="table">
            <?php foreach ($preview as $linha): ?>
                <tr>
                    <?php foreach ($linha as $coluna): ?>
                        <td><?= htmlspecialchars($coluna, ENT_QUOTES) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <form method="post" action="index.php?route=pessoas/importCsvCommit">
        <?= App\Lib\Csrf::input(); ?>
        <input type="hidden" name="rows" value='<?= htmlspecialchars(json_encode($rows), ENT_QUOTES) ?>'>
        <button class="btn btn-primary" type="submit">Importar</button>
    </form>
<?php endif; ?>
