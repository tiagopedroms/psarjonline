<h1>Parâmetros do sistema</h1>
<form method="post" action="index.php?route=admin/parametrosSave">
    <?= App\Lib\Csrf::input(); ?>
    <?php foreach ($parametros as $chave => $valor): ?>
        <div class="form-group">
            <label><?= htmlspecialchars($chave, ENT_QUOTES) ?></label>
            <input class="form-control" type="text" name="parametros[<?= htmlspecialchars($chave, ENT_QUOTES) ?>]" value="<?= htmlspecialchars($valor, ENT_QUOTES) ?>">
        </div>
    <?php endforeach; ?>
    <button class="btn btn-primary" type="submit">Salvar</button>
</form>
