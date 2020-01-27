<?php

namespace mini\core;

use Mini;

class Controller extends Base
{
    public function render($view, $params = [])
    {
        return Mini::$app->view->render($view, $params);
    }

    public function renderPartial($view, $params = [])
    {
        return Mini::$app->view->renderPartial($view, $params);
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
