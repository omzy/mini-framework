<?php

use Mini\Asset;

function asset_versioned(string $filename, bool $absolute = false): string
{
    $dist_path = getBaseUrl($absolute) . '/assets/';
    $directory = dirname($filename) . '/';
    $file = basename($filename);
    static $manifest;

    if (empty($manifest)) {
        $manifest_path = getBasePath() . '/assets/' . 'assets.json';
        $manifest = new Asset($manifest_path);
    }

    if (array_key_exists($file, $manifest->get())) {
        return $dist_path . $directory . $manifest->get()[$file];
    } else {
        return $dist_path . $directory . $file;
    }
}

function asset(string $filename, bool $absolute = false): string
{
    $dist_path = getBaseUrl($absolute) . '/assets/';
    $directory = dirname($filename) . '/';
    $file = basename($filename);

    return $dist_path . $directory . $file;
}

function url(string $path, bool $absolute = false): string
{
    $dist_path = getBaseUrl($absolute);
    $directory = '/';
    $file = $path;

    return $dist_path . $directory . $file;
}

function getBaseUrl(bool $absolute = false): ?string
{
    $server = $_SERVER;

    $protocol = $server['REQUEST_SCHEME'];
    $separator = '://';
    $hostname = $server['SERVER_NAME'];
    $directory = dirname($server['PHP_SELF']);

    if ($absolute) {
        return $protocol . $separator . $hostname . ($directory != '/' ? $directory : null);
    } else {
        return $directory != '/' ? $directory : null;
    }
}

function getBasePath(): string
{
    $server = $_SERVER;

    return $server['DOCUMENT_ROOT'] . dirname($server['PHP_SELF']);
}

function getRequestPath(): false|string
{
    $server = $_SERVER;

    $url = ltrim($server['REQUEST_URI'], '/');
    $parts = explode('/', $url);

    return end($parts);
}
