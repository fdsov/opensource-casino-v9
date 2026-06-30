<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$file = __DIR__ . $path;

if ($path !== '/' && is_file($file)) {
    return false;
}

if (preg_match('#^/(woocasino|frontend/Default)/#', $path)) {
    header('Location: https://cdn.jsdelivr.net/gh/CreadoDesign/opensource-casino-v9@main' . $path, true, 302);
    exit;
}

require __DIR__ . '/index.php';
