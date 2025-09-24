<?php

namespace App\Models;

use App\Lib\Audit;
use App\Lib\Db;

class Sacramento
{
    public function numerar(string $tipo): array
    {
        $paramModel = new Parametro();
        $livro = (int) $paramModel->getValue('sacramento_' . $tipo . '_livro', 1);
        $termo = (int) $paramModel->increment('sacramento_' . $tipo . '_termo');
        $folha = (int) $paramModel->increment('sacramento_' . $tipo . '_folha');
        $ano = date('Y');
        return compact('livro', 'termo', 'folha', 'ano');
    }

    public function gerarCodigoVerificacao(): string
    {
        return substr(bin2hex(random_bytes(10)), 0, 12);
    }

    public function create(array $data): int
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('INSERT INTO sacramentos (pessoa_id, tipo, data, livro, folha, termo, celebrante, local, codigo_verificacao, obs, criado_em) VALUES (?,?,?,?,?,?,?,?,?,?,NOW())');
        $stmt->bind_param('isssssssss', $data['pessoa_id'], $data['tipo'], $data['data'], $data['livro'], $data['folha'], $data['termo'], $data['celebrante'], $data['local'], $data['codigo_verificacao'], $data['obs']);
        $stmt->execute();
        $id = $stmt->insert_id;
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'create', 'sacramentos', $id, 'Criou sacramento');
        return $id;
    }

    public function update(int $id, array $data): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('UPDATE sacramentos SET pessoa_id=?, tipo=?, data=?, livro=?, folha=?, termo=?, celebrante=?, local=?, obs=? WHERE id=?');
        $stmt->bind_param('issssssssi', $data['pessoa_id'], $data['tipo'], $data['data'], $data['livro'], $data['folha'], $data['termo'], $data['celebrante'], $data['local'], $data['obs'], $id);
        $stmt->execute();
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'update', 'sacramentos', $id, 'Atualizou sacramento');
    }

    public function delete(int $id): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('DELETE FROM sacramentos WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'delete', 'sacramentos', $id, 'Removeu sacramento');
    }

    public function find(int $id): ?array
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT s.*, p.nome as pessoa_nome FROM sacramentos s JOIN pessoas p ON p.id = s.pessoa_id WHERE s.id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ?: null;
    }

    public function search(array $filters): array
    {
        $conn = Db::getConnection();
        $sql = 'SELECT s.*, p.nome as pessoa_nome FROM sacramentos s JOIN pessoas p ON p.id = s.pessoa_id WHERE 1=1';
        $params = [];
        $types = '';
        if (!empty($filters['tipo'])) {
            $sql .= ' AND s.tipo = ?';
            $params[] = $filters['tipo'];
            $types .= 's';
        }
        if (!empty($filters['ano'])) {
            $sql .= ' AND YEAR(s.data) = ?';
            $params[] = $filters['ano'];
            $types .= 'i';
        }
        if (!empty($filters['celebrante'])) {
            $sql .= ' AND s.celebrante LIKE ?';
            $params[] = '%' . $filters['celebrante'] . '%';
            $types .= 's';
        }
        if (!empty($filters['livro'])) {
            $sql .= ' AND s.livro = ?';
            $params[] = $filters['livro'];
            $types .= 's';
        }
        $sql .= ' ORDER BY s.data DESC';
        $stmt = $conn->prepare($sql);
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function verificarCodigo(string $codigo): ?array
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT s.*, p.nome as pessoa_nome FROM sacramentos s JOIN pessoas p ON p.id = s.pessoa_id WHERE codigo_verificacao = ?');
        $stmt->bind_param('s', $codigo);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ?: null;
    }

    public function pdfData(int $id): ?array
    {
        return $this->find($id);
    }

    public function countAll(): int
    {
        $conn = Db::getConnection();
        $res = $conn->query('SELECT COUNT(*) AS total FROM sacramentos');
        return (int) $res->fetch_assoc()['total'];
    }

    public function exportCsv(array $filters): array
    {
        $registros = $this->search($filters);
        $rows = [];
        foreach ($registros as $registro) {
            $rows[] = [
                $registro['id'],
                $registro['tipo'],
                $registro['pessoa_nome'],
                $registro['data'],
                $registro['livro'],
                $registro['folha'],
                $registro['termo'],
                $registro['celebrante']
            ];
        }
        return $rows;
    }
}
