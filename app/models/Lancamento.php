<?php

namespace App\Models;

use App\Lib\Audit;
use App\Lib\Db;

class Lancamento
{
    public function create(array $data): int
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('INSERT INTO financeiro_lanc (data, tipo, categoria, descricao, valor, pessoa_id, referencia, criado_em) VALUES (?,?,?,?,?,?,?,NOW())');
        $pessoaId = ($data['pessoa_id'] === '' || $data['pessoa_id'] === null) ? null : (int)$data['pessoa_id'];
        $stmt->bind_param('ssssdis', $data['data'], $data['tipo'], $data['categoria'], $data['descricao'], $data['valor'], $pessoaId, $data['referencia']);
        $stmt->execute();
        $id = $stmt->insert_id;
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'create', 'financeiro_lanc', $id, 'Criou lançamento');
        return $id;
    }

    public function update(int $id, array $data): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('UPDATE financeiro_lanc SET data=?, tipo=?, categoria=?, descricao=?, valor=?, pessoa_id=?, referencia=? WHERE id=?');
        $pessoaId = ($data['pessoa_id'] === '' || $data['pessoa_id'] === null) ? null : (int)$data['pessoa_id'];
        $stmt->bind_param('ssssdisi', $data['data'], $data['tipo'], $data['categoria'], $data['descricao'], $data['valor'], $pessoaId, $data['referencia'], $id);
        $stmt->execute();
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'update', 'financeiro_lanc', $id, 'Atualizou lançamento');
    }

    public function delete(int $id): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('DELETE FROM financeiro_lanc WHERE id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'delete', 'financeiro_lanc', $id, 'Removeu lançamento');
    }

    public function search(array $filters = []): array
    {
        $conn = Db::getConnection();
        $sql = 'SELECT fl.*, p.nome as pessoa_nome FROM financeiro_lanc fl LEFT JOIN pessoas p ON p.id = fl.pessoa_id WHERE 1=1';
        $params = [];
        $types = '';
        if (!empty($filters['tipo'])) {
            $sql .= ' AND fl.tipo = ?';
            $params[] = $filters['tipo'];
            $types .= 's';
        }
        if (!empty($filters['categoria'])) {
            $sql .= ' AND fl.categoria = ?';
            $params[] = $filters['categoria'];
            $types .= 's';
        }
        if (!empty($filters['periodo_inicio']) && !empty($filters['periodo_fim'])) {
            $sql .= ' AND fl.data BETWEEN ? AND ?';
            $params[] = $filters['periodo_inicio'];
            $params[] = $filters['periodo_fim'];
            $types .= 'ss';
        }
        $sql .= ' ORDER BY fl.data DESC';
        $stmt = $conn->prepare($sql);
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function sumarizar(string $inicio, string $fim): array
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT tipo, SUM(valor) as total FROM financeiro_lanc WHERE data BETWEEN ? AND ? GROUP BY tipo');
        $stmt->bind_param('ss', $inicio, $fim);
        $stmt->execute();
        $totais = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $entrada = 0.0;
        $saida = 0.0;
        foreach ($totais as $total) {
            if ($total['tipo'] === 'entrada') {
                $entrada += (float) $total['total'];
            } else {
                $saida += (float) $total['total'];
            }
        }
        return [
            'entrada' => $entrada,
            'saida' => $saida,
            'saldo' => $entrada - $saida
        ];
    }

    public function porCategoria(string $inicio, string $fim): array
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT categoria, SUM(valor) as total FROM financeiro_lanc WHERE data BETWEEN ? AND ? GROUP BY categoria');
        $stmt->bind_param('ss', $inicio, $fim);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function saldoMesAtual(): float
    {
        $inicio = date('Y-m-01');
        $fim = date('Y-m-t');
        $totais = $this->sumarizar($inicio, $fim);
        return $totais['saldo'];
    }
}
