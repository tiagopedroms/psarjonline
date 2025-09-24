<?php

namespace App\Models;

use App\Lib\Audit;
use App\Lib\Db;

class Presenca
{
    public function registrar(int $turmaId, int $pessoaId, string $data, bool $presente, string $obs = ''): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('INSERT INTO presencas (turma_id, pessoa_id, data, presente, obs) VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE presente = VALUES(presente), obs = VALUES(obs)');
        $presenteInt = $presente ? 1 : 0;
        $stmt->bind_param('iisis', $turmaId, $pessoaId, $data, $presenteInt, $obs);
        $stmt->execute();
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'update', 'presencas', $stmt->insert_id, 'Registro de presença');
    }

    public function listarPorTurmaEPeriodo(int $turmaId, string $inicio, string $fim): array
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT pr.*, p.nome FROM presencas pr JOIN pessoas p ON p.id = pr.pessoa_id WHERE pr.turma_id = ? AND pr.data BETWEEN ? AND ? ORDER BY pr.data');
        $stmt->bind_param('iss', $turmaId, $inicio, $fim);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
