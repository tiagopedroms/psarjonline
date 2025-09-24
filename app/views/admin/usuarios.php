<h1>Usuários</h1>
<a class="btn btn-primary" href="index.php?route=admin/usuariosCreate">Novo usuário</a>
<div class="table-responsive">
<table class="table">
    <thead><tr><th>ID</th><th>Nome</th><th>Email</th><th>Perfil</th><th>Ativo</th><th>Ações</th></tr></thead>
    <tbody>
    <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= (int)$usuario['id'] ?></td>
            <td><?= htmlspecialchars($usuario['nome'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($usuario['email'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($usuario['perfil'], ENT_QUOTES) ?></td>
            <td><?= $usuario['ativo'] ? 'Sim' : 'Não' ?></td>
            <td class="table-actions">
                <a class="btn btn-secondary" href="index.php?route=admin/usuariosEdit&id=<?= (int)$usuario['id'] ?>">Editar</a>
                <form method="post" action="index.php?route=admin/usuariosReset">
                    <?= App\Lib\Csrf::input(); ?>
                    <input type="hidden" name="id" value="<?= (int)$usuario['id'] ?>">
                    <input type="hidden" name="nova_senha" value="NovaSenha123">
                    <button class="btn btn-secondary" type="submit">Resetar</button>
                </form>
                <a class="btn btn-secondary" href="index.php?route=admin/usuariosToggle&id=<?= (int)$usuario['id'] ?>">Ativar/Desativar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
