<h1>Turmas de Catequese</h1>
<a class="btn btn-primary" href="index.php?route=catequese/turmaCreate">Nova turma</a>
<div class="table-responsive">
<table class="table">
    <thead><tr><th>ID</th><th>Nome</th><th>Etapa</th><th>Ano</th><th>Dia</th><th>Responsável</th><th>Ações</th></tr></thead>
    <tbody>
    <?php foreach ($turmas as $turma): ?>
        <tr>
            <td><?= (int)$turma['id'] ?></td>
            <td><?= htmlspecialchars($turma['nome'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($turma['etapa'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($turma['ano'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($turma['dia_semana'], ENT_QUOTES) ?> <?= htmlspecialchars($turma['horario'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($turma['responsavel'], ENT_QUOTES) ?></td>
            <td class="table-actions">
                <a class="btn btn-secondary" href="index.php?route=catequese/turmaEdit&id=<?= (int)$turma['id'] ?>">Editar</a>
                <a class="btn btn-secondary" href="index.php?route=catequese/alunosIndex&turma_id=<?= (int)$turma['id'] ?>">Alunos</a>
                <a class="btn btn-secondary" href="index.php?route=catequese/presencaIndex&turma_id=<?= (int)$turma['id'] ?>">Presença</a>
                <form method="post" action="index.php?route=catequese/turmaDestroy">
                    <?= App\Lib\Csrf::input(); ?>
                    <input type="hidden" name="id" value="<?= (int)$turma['id'] ?>">
                    <button class="btn btn-primary" data-confirm="Excluir turma?" type="submit">Excluir</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
