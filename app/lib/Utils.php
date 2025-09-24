<?php

namespace App\Lib;

class Utils
{
    public static function redirect(string $route): void
    {
        header('Location: index.php?route=' . $route);
        exit;
    }

    public static function view(string $path, array $data = []): void
    {
        extract($data);
        $viewFile = __DIR__ . '/../views/' . $path . '.php';
        if (!file_exists($viewFile)) {
            throw new \RuntimeException('View não encontrada: ' . $path);
        }
        include __DIR__ . '/../views/layout.php';
    }

    public static function partial(string $path, array $data = []): void
    {
        extract($data);
        $file = __DIR__ . '/../views/' . $path . '.php';
        if (file_exists($file)) {
            include $file;
        }
    }

    public static function sanitizeHtml(string $html): string
    {
        return strip_tags($html, '<p><a><strong><em><ul><ol><li><br><h1><h2><h3><h4><h5><h6><table><thead><tbody><tr><td><th>');
    }

    public static function csv(array $headers, array $rows, string $filename): void
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        $output = fopen('php://output', 'w');
        fputcsv($output, $headers);
        foreach ($rows as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
        exit;
    }

    public static function ics(string $content, string $filename): void
    {
        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        echo $content;
        exit;
    }

    public static function json(array $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
