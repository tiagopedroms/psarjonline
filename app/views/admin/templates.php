<h1>Templates para PDFs</h1>
<form method="post" action="index.php?route=admin/templatesSave">
    <?= App\Lib\Csrf::input(); ?>
    <div class="form-group">
        <label>Template Certidão</label>
        <textarea class="form-control" name="template_certidao" rows="6"><?= htmlspecialchars($templates['certidao'] ?? '', ENT_QUOTES) ?></textarea>
    </div>
    <div class="form-group">
        <label>Template Recibo</label>
        <textarea class="form-control" name="template_recibo" rows="6"><?= htmlspecialchars($templates['recibo'] ?? '', ENT_QUOTES) ?></textarea>
    </div>
    <div class="form-group">
        <label>Template Relatório</label>
        <textarea class="form-control" name="template_relatorio" rows="6"><?= htmlspecialchars($templates['relatorio'] ?? '', ENT_QUOTES) ?></textarea>
    </div>
    <button class="btn btn-primary" type="submit">Salvar</button>
</form>
