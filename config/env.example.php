<?php
return [
    'db_host' => '127.0.0.1',
    'db_name' => 'psarjonline',
    'db_user' => 'root',
    'db_pass' => 'secret',
    'db_port' => 3306,
    'app_env' => 'development',
    'app_debug' => true,
    'app_url' => 'http://localhost:8000',
    'session_name' => 'psarj_session',
    'csrf_secret' => 'change-me',
    'rate_limit' => [
        'max_attempts' => 20,
        'decay_seconds' => 60
    ],
    'mail' => [
        'host' => 'smtp.example.com',
        'port' => 587,
        'username' => 'user@example.com',
        'password' => 'password',
        'from_email' => 'no-reply@paroquia.local',
        'from_name' => 'Paróquia Santo Agostinho e Santa Rita de Cássia'
    ]
];
