<?php

namespace App\Models;

use App\Lib\Audit;
use App\Lib\Db;
use App\Lib\Validator;

class IntencaoMissa
{
    public function validatePublico(array $data): array
    {
        $validator = new Validator();
        $validator->require('ofertante_nome', $data['ofertante_nome'] ?? null, 'Nome é obrigatório');
        $validator->require('ofertante_contato', $data['ofertante_contato'] ?? null, 'Contato é obrigatório');
        $validator->require('data', $data['data'] ?? null, 'Data é obrigatória');
        $validator->maxLength('intencao_texto', $data['intencao_texto'] ?? null, 500, 'Máximo de 500 caracteres');
        $validator->numeric('valor', $data['valor'] ?? null, 'Valor inválido');
        return $validator->errors();
    }

    public function create(array $data): int
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('INSERT INTO intencoes_missa (data, horario, ofertante_nome, ofertante_contato, intencao_texto, valor, status, comprovante_path, criado_em) VALUES (?,?,?,?,?,?,?,?,NOW())');
        $stmt->bind_param('ssssssss', $data['data'], $data['horario'], $data['ofertante_nome'], $data['ofertante_contato'], $data['intencao_texto'], $data['valor'], $data['status'], $data['comprovante_path']);
        $stmt->execute();
        $id = $stmt->insert_id;
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'create', 'intencoes_missa', $id, 'Criou intenção');
        return $id;
    }

    public function createPublico(array $data): int
    {
        $conn = Db::getConnection();
        $status = 'pendente';
        $stmt = $conn->prepare('INSERT INTO intencoes_missa (data, horario, ofertante_nome, ofertante_contato, intencao_texto, valor, status, criado_em) VALUES (?,?,?,?,?,?,?,NOW())');
        $stmt->bind_param('sssssss', $data['data'], $data['horario'], $data['ofertante_nome'], $data['ofertante_contato'], $data['intencao_texto'], $data['valor'], $status);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function update(int $id, array $data): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('UPDATE intencoes_missa SET data=?, horario=?, ofertante_nome=?, ofertante_contato=?, intencao_texto=?, valor=?, status=? WHERE id=?');
        $stmt->bind_param('sssssssi', $data['data'], $data['horario'], $data['ofertante_nome'], $data['ofertante_contato'], $data['intencao_texto'], $data['valor'], $data['status'], $id);
        $stmt->execute();
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'update', 'intencoes_missa', $id, 'Atualizou intenção');
    }

    public function bulkUpdate(array $ids, string $status): void
    {
        if (!$ids) {
            return;
        }
        $conn = Db::getConnection();
        $in = implode(',', array_map('intval', $ids));
        $conn->query("UPDATE intencoes_missa SET status = '" . $conn->real_escape_string($status) . "' WHERE id IN ($in)");
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'update', 'intencoes_missa', 0, 'Atualização em massa');
    }

    public function setComprovante(int $id, ?string $path): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('UPDATE intencoes_missa SET comprovante_path=? WHERE id=?');
        $stmt->bind_param('si', $path, $id);
        $stmt->execute();
    }

    public function celebrate(int $id): void
    {
        $conn = Db::getConnection();
        $status = 'celebrada';
        $stmt = $conn->prepare('UPDATE intencoes_missa SET status=? WHERE id=?');
        $stmt->bind_param('si', $status, $id);
        $stmt->execute();
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'update', 'intencoes_missa', $id, 'Marcada como celebrada');
    }

    public function find(int $id): ?array
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT * FROM intencoes_missa WHERE id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ?: null;
    }

    public function all(array $filters = []): array
    {
        $conn = Db::getConnection();
        $sql = 'SELECT * FROM intencoes_missa WHERE 1=1';
        $params = [];
        $types = '';
        if (!empty($filters['status'])) {
            $sql .= ' AND status = ?';
            $params[] = $filters['status'];
            $types .= 's';
        }
        if (!empty($filters['data'])) {
            $sql .= ' AND data = ?';
            $params[] = $filters['data'];
            $types .= 's';
        }
        if (!empty($filters['ofertante_nome'])) {
            $sql .= ' AND ofertante_nome LIKE ?';
            $params[] = '%' . $filters['ofertante_nome'] . '%';
            $types .= 's';
        }
        $sql .= ' ORDER BY data DESC, horario ASC';
        $stmt = $conn->prepare($sql);
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function calendarioDoDia(string $data): array
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT * FROM intencoes_missa WHERE data = ? ORDER BY horario');
        $stmt->bind_param('s', $data);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function conciliarAgenda(string $data, string $horario): bool
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT COUNT(*) as total FROM agenda WHERE tipo = "missa" AND DATE(data_inicio) = ? AND TIME(data_inicio) = ?');
        $stmt->bind_param('ss', $data, $horario);
        $stmt->execute();
        $total = (int) $stmt->get_result()->fetch_assoc()['total'];
        return $total > 0;
    }

    public function countByStatus(string $status): int
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT COUNT(*) as total FROM intencoes_missa WHERE status = ?');
        $stmt->bind_param('s', $status);
        $stmt->execute();
        return (int) $stmt->get_result()->fetch_assoc()['total'];
    }

    public function exportCsv(array $filters): array
    {
        $registros = $this->all($filters);
        $rows = [];
        foreach ($registros as $registro) {
            $rows[] = [
                $registro['id'],
                $registro['data'],
                $registro['horario'],
                $registro['ofertante_nome'],
                $registro['status'],
                $registro['valor']
            ];
        }
        return $rows;
    }
}
