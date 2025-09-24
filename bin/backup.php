<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Lib\Db;

$config = Db::loadConfig();
$filename = __DIR__ . '/../storage/backups/backup_' . date('Ymd_His') . '.sql';
$sql = '-- Backup simplificado\n';
$sql .= 'SET FOREIGN_KEY_CHECKS=0;\n';
file_put_contents($filename, $sql);
