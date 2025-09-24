<?php

namespace App\Models;

use App\Lib\Audit;
use App\Lib\Db;
use App\Lib\Utils;

class Pagina
{
    public function all(): array
    {
        $conn = Db::getConnection();
        $res = $conn->query('SELECT * FROM cms_paginas ORDER BY criado_em DESC');
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function create(array $data): int
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('INSERT INTO cms_paginas (slug, titulo, conteudo_html, publicado, criado_em, atualizado_em) VALUES (?,?,?,?,NOW(),NOW())');
        $conteudo = Utils::sanitizeHtml($data['conteudo_html']);
        $stmt->bind_param('sssi', $data['slug'], $data['titulo'], $conteudo, $data['publicado']);
        $stmt->execute();
        $id = $stmt->insert_id;
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'create', 'cms_paginas', $id, 'Criou página');
        return $id;
    }

    public function update(int $id, array $data): void
    {
        $conn = Db::getConnection();
        $conteudo = Utils::sanitizeHtml($data['conteudo_html']);
        $stmt = $conn->prepare('UPDATE cms_paginas SET slug=?, titulo=?, conteudo_html=?, publicado=?, atualizado_em=NOW() WHERE id=?');
        $stmt->bind_param('sssii', $data['slug'], $data['titulo'], $conteudo, $data['publicado'], $id);
        $stmt->execute();
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'update', 'cms_paginas', $id, 'Atualizou página');
    }

    public function delete(int $id): void
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('DELETE FROM cms_paginas WHERE id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        Audit::log((int) ($_SESSION['user_id'] ?? 0), 'delete', 'cms_paginas', $id, 'Removeu página');
    }

    public function find(int $id): ?array
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT * FROM cms_paginas WHERE id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ?: null;
    }

    public function findBySlug(string $slug): ?array
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT * FROM cms_paginas WHERE slug=?');
        $stmt->bind_param('s', $slug);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ?: null;
    }

    public function published(): array
    {
        $conn = Db::getConnection();
        $res = $conn->query('SELECT * FROM cms_paginas WHERE publicado = 1 ORDER BY criado_em DESC');
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}
