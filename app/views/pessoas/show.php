<h1>Histórico da Pessoa</h1>
<?php if (!$pessoa): ?>
    <div class="alert alert-danger">Registro não encontrado.</div>
<?php else: ?>
    <div class="card">
        <h2><?= htmlspecialchars($pessoa['nome'], ENT_QUOTES) ?></h2>
        <p>CPF: <?= htmlspecialchars($pessoa['cpf'], ENT_QUOTES) ?></p>
        <p>E-mail: <?= htmlspecialchars($pessoa['email'], ENT_QUOTES) ?></p>
        <p>Telefone: <?= htmlspecialchars($pessoa['tel'], ENT_QUOTES) ?></p>
        <p>Endereço: <?= htmlspecialchars($pessoa['endereco'], ENT_QUOTES) ?></p>
    </div>
<?php endif; ?>
<a class="btn btn-secondary" href="index.php?route=pessoas/index">Voltar</a>
