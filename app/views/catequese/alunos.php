<h1>Alunos da turma <?= htmlspecialchars($turma['nome'] ?? '', ENT_QUOTES) ?></h1>
<form method="post" action="index.php?route=catequese/alunoAdd">
    <?= App\Lib\Csrf::input(); ?>
    <input type="hidden" name="turma_id" value="<?= (int)$turma['id'] ?>">
    <div class="form-group">
        <label>ID da pessoa</label>
        <input class="form-control" type="number" name="pessoa_id" required>
    </div>
    <div class="form-group">
        <label>Status</label>
        <select class="form-control" name="status">
            <option value="ativo">Ativo</option>
            <option value="concluido">Concluído</option>
            <option value="desligado">Desligado</option>
        </select>
    </div>
    <button class="btn btn-primary" type="submit">Adicionar aluno</button>
</form>
<div class="table-responsive">
<table class="table">
    <thead><tr><th>Nome</th><th>CPF</th><th>Status</th><th>Ações</th></tr></thead>
    <tbody>
    <?php foreach ($alunos as $aluno): ?>
        <tr>
            <td><?= htmlspecialchars($aluno['nome'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($aluno['cpf'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($aluno['status'], ENT_QUOTES) ?></td>
            <td>
                <form method="post" action="index.php?route=catequese/alunoRemove">
                    <?= App\Lib\Csrf::input(); ?>
                    <input type="hidden" name="id" value="<?= (int)$aluno['id'] ?>">
                    <input type="hidden" name="turma_id" value="<?= (int)$turma['id'] ?>">
                    <button class="btn btn-primary" data-confirm="Remover aluno?" type="submit">Remover</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<a class="btn btn-secondary" href="index.php?route=catequese/exportAlunosCsv&turma_id=<?= (int)$turma['id'] ?>">Exportar CSV</a>
