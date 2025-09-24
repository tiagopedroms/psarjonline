<h1>Backups</h1>
<form method="post" action="index.php?route=admin/backupsRun">
    <?= App\Lib\Csrf::input(); ?>
    <button class="btn btn-primary" type="submit">Gerar backup</button>
</form>
<ul>
<?php foreach ($backups as $backup): ?>
    <li><a href="index.php?route=admin/backupsDownload&file=<?= urlencode($backup) ?>"><?= htmlspecialchars($backup, ENT_QUOTES) ?></a></li>
<?php endforeach; ?>
</ul>
