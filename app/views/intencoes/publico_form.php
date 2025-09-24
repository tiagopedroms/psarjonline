<h1>Solicitar Intenção de Missa</h1>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES) ?></div>
<?php endif; ?>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">Verifique os dados informados.</div>
<?php endif; ?>
<form method="post" action="index.php?route=intencoes/publicoStore">
    <?= App\Lib\Csrf::input(); ?>
    <div class="form-group">
        <label>Nome do ofertante</label>
        <input class="form-control" type="text" name="ofertante_nome" value="<?= htmlspecialchars($data['ofertante_nome'] ?? '', ENT_QUOTES) ?>" required>
    </div>
    <div class="form-group">
        <label>Contato</label>
        <input class="form-control" type="text" name="ofertante_contato" value="<?= htmlspecialchars($data['ofertante_contato'] ?? '', ENT_QUOTES) ?>" required>
    </div>
    <div class="form-group">
        <label>Data desejada</label>
        <input class="form-control" type="date" name="data" value="<?= htmlspecialchars($data['data'] ?? '', ENT_QUOTES) ?>" required>
    </div>
    <div class="form-group">
        <label>Horário desejado</label>
        <input class="form-control" type="time" name="horario" value="<?= htmlspecialchars($data['horario'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="form-group">
        <label>Intenção</label>
        <textarea class="form-control" name="intencao_texto" rows="4"><?= htmlspecialchars($data['intencao_texto'] ?? '', ENT_QUOTES) ?></textarea>
    </div>
    <div class="form-group">
        <label>Valor sugerido</label>
        <input class="form-control" type="number" step="0.01" name="valor" value="<?= htmlspecialchars($data['valor'] ?? '', ENT_QUOTES) ?>">
    </div>
    <button class="btn btn-primary" type="submit">Enviar</button>
</form>
