<?php

namespace App\Models;

use App\Lib\Audit;
use App\Lib\Db;

class Evento
{
    public function create(array $data): int
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('INSERT INTO agenda (tipo, titulo, descricao, data_inicio, data_fim, local, responsavel, publicado, criado_em) VALUES (?,?,?,?,?,?,?,?,NOW())');
        $stmt->bind_param('sssssssi', $data['tipo'], $data['titulo'], $data['descricao'], $data['data_inicio'], $data['data_fim'], $data['local'], $data['responsavel'], $data['publicado']);
        $stmt->execute();
        $id = $stmt->insert_id;
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'create', 'agenda', $id, 'Criou evento');
        return $id;
    }

    public function update(int $id, array $data): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('UPDATE agenda SET tipo=?, titulo=?, descricao=?, data_inicio=?, data_fim=?, local=?, responsavel=?, publicado=? WHERE id=?');
        $stmt->bind_param('sssssssii', $data['tipo'], $data['titulo'], $data['descricao'], $data['data_inicio'], $data['data_fim'], $data['local'], $data['responsavel'], $data['publicado'], $id);
        $stmt->execute();
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'update', 'agenda', $id, 'Atualizou evento');
    }

    public function delete(int $id): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('DELETE FROM agenda WHERE id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'delete', 'agenda', $id, 'Removeu evento');
    }

    public function find(int $id): ?array
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT * FROM agenda WHERE id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ?: null;
    }

    public function search(array $filters = []): array
    {
        $conn = Db::getConnection();
        $sql = 'SELECT * FROM agenda WHERE 1=1';
        $params = [];
        $types = '';
        if (!empty($filters['tipo'])) {
            $sql .= ' AND tipo = ?';
            $params[] = $filters['tipo'];
            $types .= 's';
        }
        if (!empty($filters['periodo_inicio']) && !empty($filters['periodo_fim'])) {
            $sql .= ' AND data_inicio BETWEEN ? AND ?';
            $params[] = $filters['periodo_inicio'];
            $params[] = $filters['periodo_fim'];
            $types .= 'ss';
        }
        if (!empty($filters['publicado'])) {
            $sql .= ' AND publicado = 1';
        }
        $sql .= ' ORDER BY data_inicio ASC';
        $stmt = $conn->prepare($sql);
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function toIcs(array $evento): string
    {
        $uid = 'evento-' . $evento['id'] . '@psarj.local';
        $inicio = date('Ymd\THis', strtotime($evento['data_inicio']));
        $fim = date('Ymd\THis', strtotime($evento['data_fim'] ?? $evento['data_inicio']));
        $lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//PSARJ//Agenda//PT-BR',
            'BEGIN:VEVENT',
            'UID:' . $uid,
            'DTSTAMP:' . gmdate('Ymd\THis\Z'),
            'DTSTART:' . $inicio,
            'DTEND:' . $fim,
            'SUMMARY:' . $this->escapeIcs($evento['titulo']),
            'DESCRIPTION:' . $this->escapeIcs($evento['descricao']),
            'LOCATION:' . $this->escapeIcs($evento['local']),
            'END:VEVENT',
            'END:VCALENDAR'
        ];
        return implode("\r\n", $lines);
    }

    private function escapeIcs(string $value): string
    {
        return addcslashes($value, "\\,;");
    }

    public function countPublicos(): int
    {
        $conn = Db::getConnection();
        $res = $conn->query('SELECT COUNT(*) as total FROM agenda WHERE publicado = 1');
        return (int) $res->fetch_assoc()['total'];
    }
}
