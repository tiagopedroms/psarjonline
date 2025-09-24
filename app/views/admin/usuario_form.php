<h1><?= $usuario ? 'Editar' : 'Novo' ?> usuário</h1>
<form method="post" action="index.php?route=admin/<?= $usuario ? 'usuariosUpdate' : 'usuariosStore' ?>">
    <?= App\Lib\Csrf::input(); ?>
    <?php if ($usuario): ?>
        <input type="hidden" name="id" value="<?= (int)$usuario['id'] ?>">
    <?php endif; ?>
    <div class="form-group">
        <label>Nome</label>
        <input class="form-control" type="text" name="nome" value="<?= htmlspecialchars($usuario['nome'] ?? '', ENT_QUOTES) ?>" required>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input class="form-control" type="email" name="email" value="<?= htmlspecialchars($usuario['email'] ?? '', ENT_QUOTES) ?>" required>
    </div>
    <div class="form-group">
        <label>Perfil</label>
        <select class="form-control" name="perfil">
            <?php foreach (['Administrador','Secretaria','Catequese','Financeiro','Pastoral','Comunicacao'] as $perfil): ?>
                <option value="<?= $perfil ?>" <?= (($usuario['perfil'] ?? '') === $perfil) ? 'selected' : '' ?>><?= $perfil ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <?php if (!$usuario): ?>
    <div class="form-group">
        <label>Senha inicial</label>
        <input class="form-control" type="password" name="senha" required>
    </div>
    <?php endif; ?>
    <label><input type="checkbox" name="ativo" value="1" <?= !empty($usuario['ativo']) ? 'checked' : '' ?>> Usuário ativo</label>
    <button class="btn btn-primary" type="submit">Salvar</button>
</form>
