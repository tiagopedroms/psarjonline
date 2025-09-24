<?php

namespace App\Models;

use App\Lib\Audit;
use App\Lib\Db;

class CatequeseTurma
{
    public function create(array $data): int
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('INSERT INTO catequese_turmas (nome, etapa, ano, dia_semana, horario, responsavel) VALUES (?,?,?,?,?,?)');
        $stmt->bind_param('ssssss', $data['nome'], $data['etapa'], $data['ano'], $data['dia_semana'], $data['horario'], $data['responsavel']);
        $stmt->execute();
        $id = $stmt->insert_id;
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'create', 'catequese_turmas', $id, 'Criou turma');
        return $id;
    }

    public function update(int $id, array $data): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('UPDATE catequese_turmas SET nome=?, etapa=?, ano=?, dia_semana=?, horario=?, responsavel=? WHERE id=?');
        $stmt->bind_param('ssssssi', $data['nome'], $data['etapa'], $data['ano'], $data['dia_semana'], $data['horario'], $data['responsavel'], $id);
        $stmt->execute();
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'update', 'catequese_turmas', $id, 'Atualizou turma');
    }

    public function delete(int $id): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('DELETE FROM catequese_turmas WHERE id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'delete', 'catequese_turmas', $id, 'Removeu turma');
    }

    public function all(): array
    {
        $conn = Db::getConnection();
        $res = $conn->query('SELECT * FROM catequese_turmas ORDER BY ano DESC, nome');
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function find(int $id): ?array
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT * FROM catequese_turmas WHERE id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ?: null;
    }
}
