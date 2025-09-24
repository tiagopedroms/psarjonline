<?php

namespace App\Models;

use App\Lib\Audit;
use App\Lib\Db;

class Usuario
{
    public function findByEmail(string $email): ?array
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT * FROM usuarios WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ?: null;
    }

    public function all(): array
    {
        $conn = Db::getConnection();
        $result = $conn->query('SELECT * FROM usuarios ORDER BY nome');
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function find(int $id): ?array
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT * FROM usuarios WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ?: null;
    }

    public function create(array $data): int
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('INSERT INTO usuarios (nome, email, senha_hash, perfil, ativo, criado_em) VALUES (?, ?, ?, ?, ?, NOW())');
        $ativo = (int) ($data['ativo'] ?? 1);
        $stmt->bind_param('ssssi', $data['nome'], $data['email'], $data['senha_hash'], $data['perfil'], $ativo);
        $stmt->execute();
        $id = $stmt->insert_id;
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'create', 'usuarios', $id, 'Criou usuário ' . $data['email']);
        return $id;
    }

    public function update(int $id, array $data): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('UPDATE usuarios SET nome = ?, email = ?, perfil = ?, ativo = ? WHERE id = ?');
        $ativo = (int) ($data['ativo'] ?? 1);
        $stmt->bind_param('sssii', $data['nome'], $data['email'], $data['perfil'], $ativo, $id);
        $stmt->execute();
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'update', 'usuarios', $id, 'Atualizou usuário');
    }

    public function resetSenha(int $id, string $hash): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('UPDATE usuarios SET senha_hash = ? WHERE id = ?');
        $stmt->bind_param('si', $hash, $id);
        $stmt->execute();
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'update', 'usuarios', $id, 'Resetou senha');
    }

    public function toggleAtivo(int $id): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('UPDATE usuarios SET ativo = 1 - ativo WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'update', 'usuarios', $id, 'Alterou status');
    }

    public function countAll(): int
    {
        $conn = Db::getConnection();
        $result = $conn->query('SELECT COUNT(*) as total FROM usuarios');
        return (int) $result->fetch_assoc()['total'];
    }
}
