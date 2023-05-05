<?php

namespace Mini;

/**
 * Get paths for assets
 */
class Asset
{
    private $manifest;

    /**
     * @param string $manifest_path
     */
    public function __construct(string $manifest_path)
    {
        if (file_exists($manifest_path)) {
            $this->manifest = json_decode(file_get_contents($manifest_path), true);
        } else {
            $this->manifest = [];
        }
    }

    /**
     * @return array|mixed
     */
    public function get()
    {
        return $this->manifest;
    }

    /**
     * @param string $key
     * @param $default
     * @return array|mixed|null
     */
    public function getPath(string $key = '', $default = null)
    {
        $collection = $this->manifest;
        if (is_null($key)) {
            return $collection;
        }
        if (isset($collection[$key])) {
            return $collection[$key];
        }
        foreach (explode('.', $key) as $segment) {
            if (!isset($collection[$segment])) {
                return $default;
            } else {
                $collection = $collection[$segment];
            }
        }
        return $collection;
    }
}
