<?php

namespace App\Models;

use App\Lib\Db;

class Auditoria
{
    public function list(array $filters = []): array
    {
        $conn = Db::getConnection();
        $sql = 'SELECT a.*, u.nome as usuario_nome FROM auditoria a LEFT JOIN usuarios u ON u.id = a.usuario_id WHERE 1=1';
        $params = [];
        $types = '';
        if (!empty($filters['usuario_id'])) {
            $sql .= ' AND a.usuario_id = ?';
            $params[] = $filters['usuario_id'];
            $types .= 'i';
        }
        if (!empty($filters['modulo'])) {
            $sql .= ' AND a.tabela = ?';
            $params[] = $filters['modulo'];
            $types .= 's';
        }
        if (!empty($filters['inicio']) && !empty($filters['fim'])) {
            $sql .= ' AND a.criado_em BETWEEN ? AND ?';
            $params[] = $filters['inicio'];
            $params[] = $filters['fim'];
            $types .= 'ss';
        }
        $sql .= ' ORDER BY a.criado_em DESC LIMIT 500';
        $stmt = $conn->prepare($sql);
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
