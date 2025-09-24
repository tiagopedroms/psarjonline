<?php

namespace App\Lib;

class Audit
{
    public static function log(int $usuarioId, string $acao, string $tabela, int $registroId, string $detalhes = ''): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('INSERT INTO auditoria (usuario_id, acao, tabela, registro_id, ip, detalhes, criado_em) VALUES (?, ?, ?, ?, ?, ?, NOW())');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'cli';
        $stmt->bind_param('ississ', $usuarioId, $acao, $tabela, $registroId, $ip, $detalhes);
        $stmt->execute();

        $logLine = sprintf("%s\t%s\t%s\t%s\t%s\n", date('c'), $usuarioId, $acao, $tabela . '#' . $registroId, $detalhes);
        file_put_contents(__DIR__ . '/../../storage/logs/app.log', $logLine, FILE_APPEND);
    }
}
