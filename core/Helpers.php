<?php

use mini\core\Asset;

function asset_versioned($filename, $absolute = false)
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

function asset($filename, $absolute = false)
{
    $dist_path = getBaseUrl($absolute) . '/assets/';
    $directory = dirname($filename) . '/';
    $file = basename($filename);

    return $dist_path . $directory . $file;
}

function url($path, $absolute = false)
{
    $dist_path = getBaseUrl($absolute);
    $directory = '/';
    $file = $path;

    return $dist_path . $directory . $file;
}

function getBaseUrl($absolute = false)
{
    $server = $_SERVER;

    $protocol = $server['REQUEST_SCHEME'];
    $seperator = '://';
    $hostname = $server['SERVER_NAME'];
    $directory = dirname($server['PHP_SELF']);

    if ($absolute == true) {
        return $protocol . $seperator . $hostname . ($directory != '/' ? $directory : null);
    } else {
        return $directory != '/' ? $directory : null;
    }
}

function getBasePath()
{
    $server = $_SERVER;

    return $server['DOCUMENT_ROOT'] . dirname($server['PHP_SELF']);
}

function getRequestPath()
{
    $server = $_SERVER;

    $url = ltrim($server['REQUEST_URI'], '/');
    $parts = explode('/', $url);

    return end($parts);
}
