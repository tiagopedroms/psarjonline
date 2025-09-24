<h1><?= $turma ? 'Editar' : 'Nova' ?> Turma</h1>
<form method="post" action="index.php?route=catequese/<?= $turma ? 'turmaUpdate' : 'turmaStore' ?>">
    <?= App\Lib\Csrf::input(); ?>
    <?php if ($turma): ?>
        <input type="hidden" name="id" value="<?= (int)$turma['id'] ?>">
    <?php endif; ?>
    <div class="form-group">
        <label>Nome</label>
        <input class="form-control" type="text" name="nome" value="<?= htmlspecialchars($turma['nome'] ?? '', ENT_QUOTES) ?>" required>
    </div>
    <div class="form-group">
        <label>Etapa</label>
        <select class="form-control" name="etapa">
            <?php foreach (['batismo','primeira eucaristia','crisma'] as $etapa): ?>
                <option value="<?= $etapa ?>" <?= (($turma['etapa'] ?? '') === $etapa) ? 'selected' : '' ?>><?= ucfirst($etapa) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>Ano</label>
        <input class="form-control" type="number" name="ano" value="<?= htmlspecialchars($turma['ano'] ?? date('Y'), ENT_QUOTES) ?>">
    </div>
    <div class="form-group">
        <label>Dia da semana</label>
        <input class="form-control" type="text" name="dia_semana" value="<?= htmlspecialchars($turma['dia_semana'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="form-group">
        <label>Horário</label>
        <input class="form-control" type="time" name="horario" value="<?= htmlspecialchars($turma['horario'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="form-group">
        <label>Responsável</label>
        <input class="form-control" type="text" name="responsavel" value="<?= htmlspecialchars($turma['responsavel'] ?? '', ENT_QUOTES) ?>">
    </div>
    <button class="btn btn-primary" type="submit">Salvar</button>
</form>
