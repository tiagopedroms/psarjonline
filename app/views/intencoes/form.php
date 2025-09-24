<h1>Nova Intenção (Admin)</h1>
<form method="post" action="index.php?route=intencoes/store">
    <?= App\Lib\Csrf::input(); ?>
    <div class="form-group">
        <label>Data</label>
        <input class="form-control" type="date" name="data" required>
    </div>
    <div class="form-group">
        <label>Horário</label>
        <input class="form-control" type="time" name="horario" required>
    </div>
    <div class="form-group">
        <label>Ofertante</label>
        <input class="form-control" type="text" name="ofertante_nome" required>
    </div>
    <div class="form-group">
        <label>Contato</label>
        <input class="form-control" type="text" name="ofertante_contato">
    </div>
    <div class="form-group">
        <label>Intenção</label>
        <textarea class="form-control" name="intencao_texto"></textarea>
    </div>
    <div class="form-group">
        <label>Valor</label>
        <input class="form-control" type="number" step="0.01" name="valor">
    </div>
    <button class="btn btn-primary" type="submit">Salvar</button>
</form>
