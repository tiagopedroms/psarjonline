<?php

namespace App\Models;

use App\Lib\Audit;
use App\Lib\Db;

class CatequeseAluno
{
    public function add(int $turmaId, int $pessoaId, string $status, string $obs = ''): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('INSERT INTO catequese_alunos (turma_id, pessoa_id, status, obs) VALUES (?,?,?,?)');
        $stmt->bind_param('iiss', $turmaId, $pessoaId, $status, $obs);
        $stmt->execute();
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'create', 'catequese_alunos', $stmt->insert_id, 'Vinculou aluno');
    }

    public function remove(int $id): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('DELETE FROM catequese_alunos WHERE id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'delete', 'catequese_alunos', $id, 'Removeu aluno');
    }

    public function byTurma(int $turmaId): array
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT ca.*, p.nome, p.cpf FROM catequese_alunos ca JOIN pessoas p ON p.id = ca.pessoa_id WHERE ca.turma_id = ? ORDER BY p.nome');
        $stmt->bind_param('i', $turmaId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
