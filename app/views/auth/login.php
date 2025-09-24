<div class="card">
    <h1>Login</h1>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES) ?></div>
    <?php endif; ?>
    <form method="post" action="index.php?route=auth/authenticate">
        <?= App\Lib\Csrf::input(); ?>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input class="form-control" type="email" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="password">Senha</label>
            <input class="form-control" type="password" name="password" id="password" required>
        </div>
        <button class="btn btn-primary" type="submit">Entrar</button>
    </form>
</div>
