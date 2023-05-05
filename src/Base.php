<?php

namespace Mini;

class Base
{
    /**
     * @return mixed
     */
    public function getBasePath()
    {
        return Mini::$app->base_path;
    }

    /**
     * @return mixed
     */
    public function getApplicationPath()
    {
        return Mini::$app->app_path;
    }

    /**
     * @return string
     */
    public function getViewPath(): string
    {
        return $this->getApplicationPath() . DIRECTORY_SEPARATOR . 'views';
    }

    /**
     * @param string $view
     * @return string
     */
    public function getViewFile(string $view): string
    {
        return $this->getViewPath() . DIRECTORY_SEPARATOR . $view . '.php';
    }

    /**
     * @return string
     */
    public function getLayoutPath(): string
    {
        return $this->getViewPath() . DIRECTORY_SEPARATOR . 'layouts';
    }

    /**
     * @return string
     */
    public function getLayoutFile(): string
    {
        return $this->getLayoutPath() . DIRECTORY_SEPARATOR . 'main.php';
    }
}
