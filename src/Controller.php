<?php

namespace Mini;

class Controller extends Base
{
    public function render(string $view, array $params = [])
    {
        return Mini::$app->view->render($view, $params);
    }

    public function renderPartial(string $view, array $params = [])
    {
        return Mini::$app->view->renderPartial($view, $params);
    }

    public function getRequestMethod(): string
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            return strtoupper($_SERVER['REQUEST_METHOD']);
        }

        return 'GET';
    }

    public function isPostRequest(): bool
    {
        return $this->getRequestMethod() == 'POST';
    }

    public function isGetRequest(): bool
    {
        return $this->getRequestMethod() == 'GET';
    }

    public function isAjaxRequest(): bool
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
    }

    public function asJsonResponse(array $data): null
    {
        header('Content-Type: application/json;charset=utf-8');
        echo json_encode($data);
        return null;
    }
}
