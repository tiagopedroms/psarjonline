<?php

namespace App\Models;

use App\Lib\Db;

class Parametro
{
    public function getAll(): array
    {
        $conn = Db::getConnection();
        $res = $conn->query('SELECT * FROM parametros ORDER BY chave');
        $dados = [];
        while ($row = $res->fetch_assoc()) {
            $dados[$row['chave']] = $row['valor'];
        }
        return $dados;
    }

    public function getValue(string $key, $default = null)
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT valor FROM parametros WHERE chave = ?');
        $stmt->bind_param('s', $key);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res['valor'] ?? $default;
    }

    public function setValue(string $key, string $value): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('INSERT INTO parametros (chave, valor) VALUES (?, ?) ON DUPLICATE KEY UPDATE valor = VALUES(valor)');
        $stmt->bind_param('ss', $key, $value);
        $stmt->execute();
    }

    public function increment(string $key): int
    {
        $conn = Db::getConnection();
        $conn->query("INSERT INTO parametros (chave, valor) VALUES ('" . $conn->real_escape_string($key) . "', '0') ON DUPLICATE KEY UPDATE valor = valor");
        $conn->query("UPDATE parametros SET valor = valor + 1 WHERE chave = '" . $conn->real_escape_string($key) . "'");
        $stmt = $conn->prepare('SELECT valor FROM parametros WHERE chave = ?');
        $stmt->bind_param('s', $key);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return (int) $res['valor'];
    }
}
