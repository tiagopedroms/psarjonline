<h1>Consulta de Certidão</h1>
<form method="get" action="index.php">
    <input type="hidden" name="route" value="sacramentos/verificarCodigo">
    <div class="form-group">
        <label>Código de verificação</label>
        <input class="form-control" type="text" name="codigo" value="<?= htmlspecialchars($_GET['codigo'] ?? '', ENT_QUOTES) ?>">
    </div>
    <button class="btn btn-primary" type="submit">Consultar</button>
</form>
<?php if (!empty($registro)): ?>
    <div class="card">
        <h2><?= htmlspecialchars($registro['pessoa_nome'], ENT_QUOTES) ?></h2>
        <p>Tipo: <?= htmlspecialchars($registro['tipo'], ENT_QUOTES) ?></p>
        <p>Data: <?= htmlspecialchars($registro['data'], ENT_QUOTES) ?></p>
    </div>
<?php elseif (isset($_GET['codigo'])): ?>
    <div class="alert alert-danger">Código não encontrado.</div>
<?php endif; ?>
