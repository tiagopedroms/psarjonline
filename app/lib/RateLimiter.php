<?php

namespace App\Lib;

class RateLimiter
{
    public static function allow(string $key): bool
    {
        Auth::startSession();
        $config = Db::loadConfig();
        $limit = $config['rate_limit']['max_attempts'] ?? 10;
        $decay = $config['rate_limit']['decay_seconds'] ?? 60;

        $now = time();
        $windowKey = $key . '_' . intdiv($now, $decay);

        if (!isset($_SESSION['rate_limit'][$windowKey])) {
            $_SESSION['rate_limit'] = array_filter($_SESSION['rate_limit'] ?? [], function ($timestamp) use ($now, $decay) {
                return $timestamp >= $now - $decay;
            });
            $_SESSION['rate_limit'][$windowKey] = 0;
        }

        if ($_SESSION['rate_limit'][$windowKey] >= $limit) {
            return false;
        }

        $_SESSION['rate_limit'][$windowKey]++;
        return true;
    }
}
