<h1>Permissões por perfil</h1>
<form method="post" action="index.php?route=admin/permissoesUpdate">
    <?= App\Lib\Csrf::input(); ?>
    <div class="form-group">
        <label>Perfil</label>
        <select class="form-control" name="perfil">
            <?php foreach (['Administrador','Secretaria','Catequese','Financeiro','Pastoral','Comunicacao'] as $perfil): ?>
                <option value="<?= $perfil ?>"><?= $perfil ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <table class="table">
        <thead><tr><th>Módulo</th><th>Ação</th><th>Permitido</th></tr></thead>
        <tbody>
        <?php foreach ($matriz as $perfil => $modulos): ?>
            <?php foreach ($modulos as $modulo => $acoes): ?>
                <?php foreach ($acoes as $acao => $permitido): ?>
                <tr>
                    <td><?= htmlspecialchars($modulo, ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($acao, ENT_QUOTES) ?></td>
                    <td><input type="checkbox" name="permissoes[<?= $modulo ?>][<?= $acao ?>]" value="1" <?= $permitido ? 'checked' : '' ?>></td>
                </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
    <button class="btn btn-primary" type="submit">Salvar</button>
</form>
