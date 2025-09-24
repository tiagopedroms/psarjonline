<h1>Agenda</h1>
<div class="card">
    <a class="btn btn-primary" href="index.php?route=agenda/create">Novo evento</a>
    <a class="btn btn-secondary" href="index.php?route=agenda/exportCsv">Exportar CSV</a>
    <a class="btn btn-secondary" href="index.php?route=agenda/viewCalendar">Calendário</a>
</div>
<div class="table-responsive">
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Tipo</th>
            <th>Início</th>
            <th>Publicado</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($eventos as $evento): ?>
        <tr>
            <td><?= (int)$evento['id'] ?></td>
            <td><?= htmlspecialchars($evento['titulo'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($evento['tipo'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($evento['data_inicio'], ENT_QUOTES) ?></td>
            <td><?= $evento['publicado'] ? 'Sim' : 'Não' ?></td>
            <td class="table-actions">
                <a class="btn btn-secondary" href="index.php?route=agenda/edit&id=<?= (int)$evento['id'] ?>">Editar</a>
                <a class="btn btn-secondary" href="index.php?route=agenda/ics&id=<?= (int)$evento['id'] ?>">.ICS</a>
                <a class="btn btn-secondary" href="index.php?route=agenda/publicarToggle&id=<?= (int)$evento['id'] ?>">Publicar</a>
                <form method="post" action="index.php?route=agenda/destroy">
                    <?= App\Lib\Csrf::input(); ?>
                    <input type="hidden" name="id" value="<?= (int)$evento['id'] ?>">
                    <button class="btn btn-primary" data-confirm="Excluir evento?" type="submit">Excluir</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
