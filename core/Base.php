<?php

namespace mini\core;

use Mini;

class Base
{
    public function getBasePath()
    {
        return Mini::$app->base_path;
    }

    public function getApplicationPath()
    {
        return Mini::$app->app_path;
    }

    public function getViewPath()
    {
        return $this->getApplicationPath() . DIRECTORY_SEPARATOR . 'views';
    }

    public function getViewFile($view)
    {
        return $this->getViewPath() . DIRECTORY_SEPARATOR . $view . '.php';
    }

    public function getLayoutPath()
    {
        return $this->getViewPath() . DIRECTORY_SEPARATOR . 'layouts';
    }

    public function getLayoutFile()
    {
        return $this->getLayoutPath() . DIRECTORY_SEPARATOR . 'main.php';
    }
}
