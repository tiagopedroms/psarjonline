<?php

namespace App\Models;

use App\Lib\Audit;
use App\Lib\Db;
use App\Lib\Validator;

class Pessoa
{
    public function validate(array $data): array
    {
        $validator = new Validator();
        $validator->require('nome', $data['nome'] ?? null, 'Nome é obrigatório');
        $validator->require('cpf', $data['cpf'] ?? null, 'CPF é obrigatório');
        if (!empty($data['cpf']) && !preg_match('/^\d{11}$/', preg_replace('/\D/', '', $data['cpf']))) {
            $validator->require('cpf', null, 'CPF inválido');
        }
        $validator->email('email', $data['email'] ?? null, 'E-mail inválido');
        return $validator->errors();
    }

    public function formatData(array $data): array
    {
        $data['cpf'] = preg_replace('/\D/', '', $data['cpf'] ?? '');
        $data['cep'] = preg_replace('/\D/', '', $data['cep'] ?? '');
        $data['tel'] = preg_replace('/\D/', '', $data['tel'] ?? '');
        return $data;
    }

    public function find(int $id): ?array
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT * FROM pessoas WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ?: null;
    }

    public function findByCpf(string $cpf): ?array
    {
        $cpf = preg_replace('/\D/', '', $cpf);
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT * FROM pessoas WHERE cpf = ? LIMIT 1');
        $stmt->bind_param('s', $cpf);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ?: null;
    }

    public function create(array $data): int
    {
        $data = $this->formatData($data);
        $conn = Db::getConnection();
        $stmt = $conn->prepare('INSERT INTO pessoas (nome, cpf, rg, dt_nasc, email, tel, endereco, bairro, cidade, uf, cep, obs, criado_em) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,NOW())');
        $stmt->bind_param('ssssssssssss', $data['nome'], $data['cpf'], $data['rg'], $data['dt_nasc'], $data['email'], $data['tel'], $data['endereco'], $data['bairro'], $data['cidade'], $data['uf'], $data['cep'], $data['obs']);
        $stmt->execute();
        $id = $stmt->insert_id;
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'create', 'pessoas', $id, 'Criou pessoa');
        return $id;
    }

    public function update(int $id, array $data): void
    {
        $data = $this->formatData($data);
        $conn = Db::getConnection();
        $stmt = $conn->prepare('UPDATE pessoas SET nome=?, cpf=?, rg=?, dt_nasc=?, email=?, tel=?, endereco=?, bairro=?, cidade=?, uf=?, cep=?, obs=? WHERE id=?');
        $stmt->bind_param('ssssssssssssi', $data['nome'], $data['cpf'], $data['rg'], $data['dt_nasc'], $data['email'], $data['tel'], $data['endereco'], $data['bairro'], $data['cidade'], $data['uf'], $data['cep'], $data['obs'], $id);
        $stmt->execute();
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'update', 'pessoas', $id, 'Atualizou pessoa');
    }

    public function delete(int $id): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('DELETE FROM pessoas WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'delete', 'pessoas', $id, 'Removeu pessoa');
    }

    public function search(array $filters): array
    {
        $conn = Db::getConnection();
        $sql = 'SELECT * FROM pessoas WHERE 1=1';
        $params = [];
        $types = '';
        if (!empty($filters['nome'])) {
            $sql .= ' AND nome LIKE ?';
            $params[] = '%' . $filters['nome'] . '%';
            $types .= 's';
        }
        if (!empty($filters['cpf'])) {
            $sql .= ' AND cpf = ?';
            $params[] = preg_replace('/\D/', '', $filters['cpf']);
            $types .= 's';
        }
        if (!empty($filters['cidade'])) {
            $sql .= ' AND cidade = ?';
            $params[] = $filters['cidade'];
            $types .= 's';
        }
        if (!empty($filters['uf'])) {
            $sql .= ' AND uf = ?';
            $params[] = $filters['uf'];
            $types .= 's';
        }
        if (!empty($filters['status'])) {
            $sql .= ' AND obs LIKE ?';
            $params[] = '%' . $filters['status'] . '%';
            $types .= 's';
        }
        $sql .= ' ORDER BY nome';

        $stmt = $conn->prepare($sql);
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function merge(array $ids): ?int
    {
        if (count($ids) < 2) {
            return null;
        }
        $conn = Db::getConnection();
        $primaryId = array_shift($ids);
        foreach ($ids as $id) {
            $conn->query('UPDATE sacramentos SET pessoa_id = ' . (int) $primaryId . ' WHERE pessoa_id = ' . (int) $id);
            $conn->query('UPDATE intencoes_missa SET pessoa_id = ' . (int) $primaryId . ' WHERE pessoa_id = ' . (int) $id);
            $conn->query('UPDATE catequese_alunos SET pessoa_id = ' . (int) $primaryId . ' WHERE pessoa_id = ' . (int) $id);
            $conn->query('UPDATE presencas SET pessoa_id = ' . (int) $primaryId . ' WHERE pessoa_id = ' . (int) $id);
            $conn->query('UPDATE financeiro_lanc SET pessoa_id = ' . (int) $primaryId . ' WHERE pessoa_id = ' . (int) $id);
            $conn->query('DELETE FROM pessoas WHERE id = ' . (int) $id);
        }
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'update', 'pessoas', $primaryId, 'Merge de registros');
        return $primaryId;
    }

    public function countAll(): int
    {
        $conn = Db::getConnection();
        $res = $conn->query('SELECT COUNT(*) AS total FROM pessoas');
        return (int) $res->fetch_assoc()['total'];
    }
}
