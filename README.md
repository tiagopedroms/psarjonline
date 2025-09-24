# PSARJ Online

Sistema web completo em PHP + MySQL para a Paróquia Santo Agostinho e Santa Rita de Cássia.

## Requisitos

- PHP 8.x
- MySQL ou MariaDB
- Extensão `mysqli`

## Instalação

1. Copie `config/env.example.php` para `config/env.php` e ajuste as credenciais do banco e SMTP.
2. Crie o banco de dados e importe `sql/schema.sql` e `sql/seeds.sql`.
3. Garanta permissões de escrita para `storage/uploads`, `storage/logs` e `storage/backups`.
4. Inicie o servidor embutido do PHP: `php -S localhost:8000 -t public`.
5. Acesse `http://localhost:8000` e realize login com `admin@paroquia.local / Admin@123`.

## Estrutura

- `public/`: arquivos públicos e ponto de entrada `index.php`.
- `app/controllers`: controladores MVC.
- `app/models`: modelos com consultas SQL.
- `app/views`: layouts e telas para área administrativa e pública.
- `app/lib`: utilitários (Auth, Db, Csrf, Validator, Pdf, Mailer, etc.).
- `sql/`: schema e seeds do banco de dados.
- `storage/`: uploads, logs e backups.
- `vendor/`: bibliotecas standalone (TCPDF e PHPMailer simplificados).

## Funcionalidades

- Autenticação com perfis e controle de permissões.
- CRUD de pessoas, sacramentos, intenções, agenda, catequese, financeiro e CMS.
- Exportações CSV, geração de PDFs (certidões, relatórios, recibos) e arquivos .ICS.
- Auditoria de ações, gestão de parâmetros, backups e templates.
- Formulários públicos para intenções, consulta de certidões e páginas CMS.

## Segurança

- Sessões com `password_hash`/`verify`.
- CSRF obrigatório em todos os POSTs (`App\Lib\Csrf`).
- Uploads direcionados a `storage/uploads` com validação de MIME e tamanho.
- Logs gravados em `storage/logs/app.log` e `storage/logs/mail.log`.
- Rate limit para formulários públicos via `App\Lib\RateLimiter`.

## Debug

O modo debug é controlado pelo arquivo `config/env.php`. Configure `app_debug => true` apenas em ambiente de desenvolvimento.
