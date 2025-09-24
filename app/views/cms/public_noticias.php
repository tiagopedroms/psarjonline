<h1>Notícias</h1>
<?php foreach ($paginas as $pagina): ?>
    <article class="card">
        <h2><?= htmlspecialchars($pagina['titulo'], ENT_QUOTES) ?></h2>
        <div><?= $pagina['conteudo_html'] ?></div>
    </article>
<?php endforeach; ?>
