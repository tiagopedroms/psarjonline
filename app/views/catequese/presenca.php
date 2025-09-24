<h1>Presença - <?= htmlspecialchars($turma['nome'] ?? '', ENT_QUOTES) ?></h1>
<form method="post" action="index.php?route=catequese/presencaStore">
    <?= App\Lib\Csrf::input(); ?>
    <input type="hidden" name="turma_id" value="<?= (int)$turma['id'] ?>">
    <div class="form-group">
        <label>Data</label>
        <input class="form-control" type="date" name="data" value="<?= date('Y-m-d') ?>">
    </div>
    <table class="table">
        <thead><tr><th>Aluno</th><th>Presente?</th></tr></thead>
        <tbody>
        <?php foreach ($alunos as $aluno): ?>
            <tr>
                <td><?= htmlspecialchars($aluno['nome'], ENT_QUOTES) ?></td>
                <td>
                    <select class="form-control" name="presencas[<?= (int)$aluno['pessoa_id'] ?>]">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <button class="btn btn-primary" type="submit">Registrar</button>
</form>
