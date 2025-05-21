<?php

namespace Mini;

class Base
{
    public function getBasePath(): string
    {
        return Mini::$app->base_path;
    }

    public function getApplicationPath(): string
    {
        return Mini::$app->app_path;
    }

    public function getViewPath(): string
    {
        return $this->getApplicationPath() . DIRECTORY_SEPARATOR . 'views';
    }

    public function getViewFile(string $view): string
    {
        return $this->getViewPath() . DIRECTORY_SEPARATOR . $view . '.php';
    }

    public function getLayoutPath(): string
    {
        return $this->getViewPath() . DIRECTORY_SEPARATOR . 'layouts';
    }

    public function getLayoutFile(): string
    {
        return $this->getLayoutPath() . DIRECTORY_SEPARATOR . 'main.php';
    }
}
