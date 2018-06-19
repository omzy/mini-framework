<?php

namespace mini\core;

use Base;

class Controller
{
    public $config;
    public $params;

    public function __construct()
    {
        $this->config = Base::$app->config;
        $this->params = Base::$app->params;
    }

    public function render($view, $viewData = null)
    {
        $config = $this->config;
        $params = $this->params;

        if (file_exists(APP . 'views/' . $view . '.php')) {
            require(APP . 'views/layouts/main.php');
        }

        return;
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
