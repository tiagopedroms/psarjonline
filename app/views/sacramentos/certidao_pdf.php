<h1 style="text-align:center;">Certidão de <?= htmlspecialchars($registro['tipo'], ENT_QUOTES) ?></h1>
<p>Paróquia Santo Agostinho e Santa Rita de Cássia</p>
<p>Certificamos que <?= htmlspecialchars($registro['pessoa_nome'], ENT_QUOTES) ?> recebeu o sacramento em <?= htmlspecialchars($registro['data'], ENT_QUOTES) ?> no local <?= htmlspecialchars($registro['local'], ENT_QUOTES) ?>.</p>
<p>Livro: <?= htmlspecialchars($registro['livro'], ENT_QUOTES) ?> | Folha: <?= htmlspecialchars($registro['folha'], ENT_QUOTES) ?> | Termo: <?= htmlspecialchars($registro['termo'], ENT_QUOTES) ?></p>
<?php if (!empty($segunda_via)): ?>
<p><strong>Segunda via</strong></p>
<?php endif; ?>
<p>Código de verificação: <?= htmlspecialchars($registro['codigo_verificacao'], ENT_QUOTES) ?></p>
