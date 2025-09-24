<h1 style="text-align:center;">Recibo de Intenção de Missa</h1>
<p>Recebemos de <?= htmlspecialchars($intencao['ofertante_nome'], ENT_QUOTES) ?> a intenção descrita:</p>
<p><?= nl2br(htmlspecialchars($intencao['intencao_texto'], ENT_QUOTES)) ?></p>
<p>Data: <?= htmlspecialchars($intencao['data'], ENT_QUOTES) ?> às <?= htmlspecialchars($intencao['horario'], ENT_QUOTES) ?></p>
<p>Valor: R$ <?= number_format((float)$intencao['valor'], 2, ',', '.') ?></p>
