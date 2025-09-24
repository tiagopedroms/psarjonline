<?php

namespace App\Lib;

use mysqli;
use mysqli_sql_exception;

class Db
{
    private static ?mysqli $connection = null;

    public static function getConnection(): mysqli
    {
        if (self::$connection instanceof mysqli) {
            return self::$connection;
        }

        $config = self::loadConfig();

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $conn = new mysqli(
                $config['db_host'],
                $config['db_user'],
                $config['db_pass'],
                $config['db_name'],
                $config['db_port'] ?? 3306
            );
            $conn->set_charset('utf8mb4');
            self::$connection = $conn;
            return $conn;
        } catch (mysqli_sql_exception $e) {
            throw new \RuntimeException('Erro ao conectar ao banco de dados: ' . $e->getMessage());
        }
    }

    public static function loadConfig(): array
    {
        static $config;
        if ($config === null) {
            $path = __DIR__ . '/../../config/env.php';
            if (!file_exists($path)) {
                $path = __DIR__ . '/../../config/env.example.php';
            }
            $config = require $path;
        }
        return $config;
    }

    public static function beginTransaction(): void
    {
        self::getConnection()->begin_transaction();
    }

    public static function commit(): void
    {
        self::getConnection()->commit();
    }

    public static function rollBack(): void
    {
        self::getConnection()->rollback();
    }
}
