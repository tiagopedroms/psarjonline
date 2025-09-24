<h1><?= $pessoa ? 'Editar' : 'Nova' ?> Pessoa</h1>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $field => $messages): ?>
                <?php foreach ($messages as $message): ?>
                    <li><?= htmlspecialchars($message, ENT_QUOTES) ?></li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="post" action="index.php?route=pessoas/<?= $pessoa ? 'update' : 'store' ?>">
    <?= App\Lib\Csrf::input(); ?>
    <?php if ($pessoa): ?>
        <input type="hidden" name="id" value="<?= (int)$pessoa['id'] ?>">
    <?php endif; ?>
    <div class="form-group">
        <label>Nome</label>
        <input class="form-control" type="text" name="nome" value="<?= htmlspecialchars($pessoa['nome'] ?? '', ENT_QUOTES) ?>" required>
    </div>
    <div class="form-group">
        <label>CPF</label>
        <input class="form-control" type="text" name="cpf" value="<?= htmlspecialchars($pessoa['cpf'] ?? '', ENT_QUOTES) ?>" required>
    </div>
    <div class="form-group">
        <label>E-mail</label>
        <input class="form-control" type="email" name="email" value="<?= htmlspecialchars($pessoa['email'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="form-group">
        <label>Telefone</label>
        <input class="form-control" type="text" name="tel" value="<?= htmlspecialchars($pessoa['tel'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="form-group">
        <label>Cidade</label>
        <input class="form-control" type="text" name="cidade" value="<?= htmlspecialchars($pessoa['cidade'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="form-group">
        <label>UF</label>
        <input class="form-control" type="text" name="uf" value="<?= htmlspecialchars($pessoa['uf'] ?? '', ENT_QUOTES) ?>">
    </div>
    <button class="btn btn-primary" type="submit">Salvar</button>
    <a class="btn btn-secondary" href="index.php?route=pessoas/index">Voltar</a>
</form>
