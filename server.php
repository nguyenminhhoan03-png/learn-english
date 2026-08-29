<?php

declare(strict_types=1);

/**
 * Laravel - High-Performance Local Dev Server Router with Cache Headers
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

$filePath = __DIR__ . '/public' . $uri;

// Serve static assets with full 1-year browser cache headers in development server
if ($uri !== '/' && file_exists($filePath) && !is_dir($filePath)) {
    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    
    $mimes = [
        'css' => 'text/css; charset=UTF-8',
        'js' => 'application/javascript; charset=UTF-8',
        'woff2' => 'font/woff2',
        'woff' => 'font/woff',
        'ttf' => 'font/ttf',
        'svg' => 'image/svg+xml',
        'webp' => 'image/webp',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'ico' => 'image/x-icon',
        'json' => 'application/json',
    ];

    if (isset($mimes[$ext])) {
        header('Content-Type: ' . $mimes[$ext]);
        header('Cache-Control: public, max-age=31536000, immutable');
        header('Access-Control-Allow-Origin: *');
        header('X-Content-Type-Options: nosniff');
        
        $content = file_get_contents($filePath);
        $acceptEncoding = $_SERVER['HTTP_ACCEPT_ENCODING'] ?? '';
        
        if (str_contains($acceptEncoding, 'gzip') && in_array($ext, ['css', 'js', 'svg', 'json'])) {
            header('Content-Encoding: gzip');
            header('Vary: Accept-Encoding');
            echo gzencode($content, 9);
        } else {
            header('Content-Length: ' . (string) strlen($content));
            echo $content;
        }
        exit;
    }

    return false;
}

require_once __DIR__ . '/public/index.php';
