<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$file = __DIR__ . $path;

if ($path !== '/' && is_file($file)) {
    return false;
}

if (preg_match('#^/games/(.+)$#', $path, $matches)) {
    $gamesRoot = realpath(__DIR__ . '/casino/app/Games');
    $gameFile = realpath(__DIR__ . '/casino/app/Games/' . $matches[1]);
    $extension = strtolower(pathinfo($gameFile ?: '', PATHINFO_EXTENSION));
    $allowedExtensions = [
        'html', 'htm', 'js', 'css', 'json', 'xml',
        'png', 'jpg', 'jpeg', 'gif', 'svg', 'webp', 'ico',
        'mp3', 'ogg', 'ogv', 'wav', 'm4a', 'mp4', 'webm',
        'woff', 'woff2', 'ttf', 'eot',
        'wasm', 'bin', 'dat', 'data', 'pak', 'atlas', 'skel',
    ];

    if (
        $gamesRoot &&
        $gameFile &&
        is_file($gameFile) &&
        str_starts_with($gameFile, $gamesRoot . DIRECTORY_SEPARATOR) &&
        in_array($extension, $allowedExtensions, true)
    ) {
        $types = [
            'html' => 'text/html; charset=UTF-8',
            'htm' => 'text/html; charset=UTF-8',
            'js' => 'application/javascript; charset=UTF-8',
            'css' => 'text/css; charset=UTF-8',
            'json' => 'application/json; charset=UTF-8',
            'xml' => 'application/xml; charset=UTF-8',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'webp' => 'image/webp',
            'ico' => 'image/x-icon',
            'mp3' => 'audio/mpeg',
            'ogg' => 'audio/ogg',
            'ogv' => 'video/ogg',
            'wav' => 'audio/wav',
            'm4a' => 'audio/mp4',
            'mp4' => 'video/mp4',
            'webm' => 'video/webm',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'eot' => 'application/vnd.ms-fontobject',
            'wasm' => 'application/wasm',
        ];

        header('Content-Type: ' . ($types[$extension] ?? 'application/octet-stream'));
        header('Content-Length: ' . filesize($gameFile));
        readfile($gameFile);
        exit;
    }
}

if (preg_match('#^/(woocasino|frontend/Default)/#', $path)) {
    header('Location: https://cdn.jsdelivr.net/gh/CreadoDesign/opensource-casino-v9@main' . $path, true, 302);
    exit;
}

require __DIR__ . '/index.php';
