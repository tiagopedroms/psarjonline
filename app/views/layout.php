<?php use App\Lib\Auth; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'PSARJ Online', ENT_QUOTES) ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/app.css">
</head>
<body>
<nav class="navbar">
    <span class="navbar-brand">Paróquia Santo Agostinho e Santa Rita de Cássia</span>
    <?php if (Auth::check()): ?>
        <div>
            <a href="index.php?route=dashboard/index">Painel</a>
            <a href="index.php?route=pessoas/index">Pessoas</a>
            <a href="index.php?route=sacramentos/index">Sacramentos</a>
            <a href="index.php?route=intencoes/index">Intenções</a>
            <a href="index.php?route=agenda/index">Agenda</a>
            <a href="index.php?route=catequese/turmasIndex">Catequese</a>
            <a href="index.php?route=financeiro/index">Financeiro</a>
            <a href="index.php?route=cms/paginasIndex">CMS</a>
            <a href="index.php?route=admin/usuariosIndex">Administração</a>
        </div>
        <span class="user"><?= htmlspecialchars(Auth::user()['nome'] ?? '', ENT_QUOTES) ?> | <a href="index.php?route=auth/logout">Sair</a></span>
    <?php else: ?>
        <span class="user"><a href="index.php?route=auth/login">Entrar</a></span>
    <?php endif; ?>
</nav>
<div class="container">
    <?php include $viewFile; ?>
</div>
<footer>
    &copy; <?= date('Y') ?> Paróquia Santo Agostinho e Santa Rita de Cássia
</footer>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/datatables.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>
