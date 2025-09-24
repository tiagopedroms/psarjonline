<div class="row">
    <div class="col-4">
        <div class="card">
            <h3>Pessoas cadastradas</h3>
            <p><?= (int)($stats['pessoas'] ?? 0) ?></p>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <h3>Sacramentos registrados</h3>
            <p><?= (int)($stats['sacramentos'] ?? 0) ?></p>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <h3>Intenções pendentes</h3>
            <p><?= (int)($stats['intencoes_pendentes'] ?? 0) ?></p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="card">
            <h3>Eventos publicados</h3>
            <p><?= (int)($stats['eventos_publicados'] ?? 0) ?></p>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <h3>Saldo do mês</h3>
            <p>R$ <?= number_format((float)($stats['saldo_mensal'] ?? 0), 2, ',', '.') ?></p>
        </div>
    </div>
</div>
