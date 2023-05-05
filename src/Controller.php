<?php

namespace Mini;

class Controller extends Base
{
    /**
     * @param string $view
     * @param array $params
     * @return mixed
     */
    public function render(string $view, array $params = [])
    {
        return Mini::$app->view->render($view, $params);
    }

    /**
     * @param string $view
     * @param array $params
     * @return mixed
     */
    public function renderPartial(string $view, array $params = [])
    {
        return Mini::$app->view->renderPartial($view, $params);
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            return strtoupper($_SERVER['REQUEST_METHOD']);
        }

        return 'GET';
    }

    /**
     * @return bool
     */
    public function isPostRequest(): bool
    {
        return $this->getRequestMethod() == 'POST';
    }

    /**
     * @return bool
     */
    public function isGetRequest(): bool
    {
        return $this->getRequestMethod() == 'GET';
    }

    /**
     * @return bool
     */
    public function isAjaxRequest(): bool
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
    }

    /**
     * @param array $data
     * @return void
     */
    public function asJsonResponse(array $data)
    {
        header('Content-Type: application/json;charset=utf-8');
        echo json_encode($data);
        return;
    }
}
