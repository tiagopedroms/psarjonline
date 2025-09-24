<?php

namespace App\Controllers;

use App\Lib\Auth;
use App\Lib\Utils;
use App\Models\Pessoa;
use App\Models\Sacramento;
use App\Models\IntencaoMissa;
use App\Models\Evento;
use App\Models\Lancamento;

class DashboardController extends BaseController
{
    public function index(): void
    {
        $pessoaModel = new Pessoa();
        $sacramentoModel = new Sacramento();
        $intencaoModel = new IntencaoMissa();
        $eventoModel = new Evento();
        $lancamentoModel = new Lancamento();

        $stats = [
            'pessoas' => $pessoaModel->countAll(),
            'sacramentos' => $sacramentoModel->countAll(),
            'intencoes_pendentes' => $intencaoModel->countByStatus('pendente'),
            'eventos_publicados' => $eventoModel->countPublicos(),
            'saldo_mensal' => $lancamentoModel->saldoMesAtual(),
        ];

        $this->view('dashboard/index', [
            'title' => 'Painel',
            'stats' => $stats,
            'user' => Auth::user()
        ]);
    }
}
