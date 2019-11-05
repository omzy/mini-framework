<?php

namespace mini\core;

use Mini;

class Controller extends Base
{
    public function render($view, $params = [])
    {
        $file = $this->getViewFile($view);

        if (file_exists($file)) {
            $content = $this->renderFile($file, $params);
            require($this->getLayoutFile());
        }

        return;
    }

    public function renderPartial($view, $params = [])
    {
        $file = $this->getViewFile($view);

        if (file_exists($file)) {
            return $this->renderFile($file, $params);
        }

        return;
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

    public function getRequestMethod()
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            return strtoupper($_SERVER['REQUEST_METHOD']);
        }

        return 'GET';
    }

    public function isPostRequest()
    {
        return $this->getRequestMethod() == 'POST';
    }

    public function isGetRequest()
    {
        return $this->getRequestMethod() == 'GET';
    }

    public function isAjaxRequest()
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
    }

    public function asJsonResponse($data)
    {
        header('Content-Type: application/json;charset=utf-8');
        echo json_encode($data);
        return;
    }
}
