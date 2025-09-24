<?php

namespace App\Models;

use App\Lib\Db;

class Permissao
{
    public function matriz(): array
    {
        $conn = Db::getConnection();
        $res = $conn->query('SELECT perfil, modulo, acao, permitido FROM permissoes');
        $matriz = [];
        while ($row = $res->fetch_assoc()) {
            $matriz[$row['perfil']][$row['modulo']][$row['acao']] = (bool) $row['permitido'];
        }
        return $matriz;
    }

    public function updatePerfil(string $perfil, array $permissoes): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('DELETE FROM permissoes WHERE perfil = ?');
        $stmt->bind_param('s', $perfil);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare('INSERT INTO permissoes (perfil, modulo, acao, permitido) VALUES (?, ?, ?, ?)');
        foreach ($permissoes as $modulo => $acoes) {
            foreach ($acoes as $acao => $permitido) {
                $perm = $permitido ? 1 : 0;
                $stmt->bind_param('sssi', $perfil, $modulo, $acao, $perm);
                $stmt->execute();
            }
        }
    }

    public function verifica(string $perfil, string $modulo, string $acao): bool
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT permitido FROM permissoes WHERE perfil = ? AND modulo = ? AND acao = ?');
        $stmt->bind_param('sss', $perfil, $modulo, $acao);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return (bool) ($res['permitido'] ?? false);
    }
}
