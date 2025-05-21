<?php

namespace Mini;

class App
{
    public string $base_path;
    public string $app_path;

    public ?string $url_controller = null;
    public ?string $url_action = null;
    public array $url_params = [];
    public ?string $url_route = null;

    public Controller $controller;
    public string $action;
    public View $view;

    public string $app_env;
    public bool $app_debug;
    public array $params;
    public array $mailer;

    public function __construct(array $config)
    {
        Mini::$app = $this;

        $this->configure($this, $config);
        $this->setBasePath($config['base_path']);
        $this->setAppPath();
        $this->setupErrorReporting($config['app_debug']);
    }

    public function setBasePath(string $path): void
    {
        $this->base_path = $path;
    }

    public function getBasePath(): string
    {
        return $this->base_path;
    }

    public function setAppPath(): void
    {
        $this->app_path = $this->getBasePath() . DIRECTORY_SEPARATOR . 'app';
    }

    public function getAppPath(): string
    {
        return $this->app_path;
    }

    public function configure(self $object, array $properties): object
    {
        foreach ($properties as $name => $value) {
            $object->$name = $value;
        }

        $object->view = new View();

        return $object;
    }

    public function setupErrorReporting(bool $app_debug): void
    {
        if ($app_debug) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }
    }

    public function run()
    {
        // create array with URL parts in $url
        $this->splitUrl();

        // check for controller: no controller given ? then load start-page
        if (!$this->url_controller) {
            $page = new \app\controllers\IndexController();
            return $page->actionIndex();
        }
        elseif ($this->isValidControllerOrAction($this->url_controller)) {
            $controller_name = str_replace(' ', '', ucwords(implode(' ', explode('-', $this->url_controller)))) . 'Controller';
            $controller_class = "\\app\\controllers\\" . $controller_name;

            if (class_exists($controller_class)) {
                $controller = new \ReflectionClass($controller_class);

                if ($controller->getShortName() == $controller_name) {
                    $this->controller = new $controller_class();

                    if ($this->isValidControllerOrAction($this->url_action)) {
                        $method_name = 'action' . str_replace(' ', '', ucwords(implode(' ', explode('-', $this->url_action))));

                        // check for method: does such a method exist in the controller ?
                        if (method_exists($this->controller, $method_name)) {
                            $method = new \ReflectionMethod($this->controller, $method_name);

                            if ($method->getName() == $method_name) {
                                $this->action = $method_name;

                                if (!empty($this->url_params)) {
                                    // Call the method and pass arguments to it
                                    return call_user_func_array([$this->controller, $this->action], $this->url_params);
                                }
                                else {
                                    // If no parameters are given, just call the method without parameters, like $this->home->method();
                                    return $this->controller->{$this->action}();
                                }
                            }
                        }
                        elseif (strlen($this->url_action) == 0) {
                            // no action defined: call the default index() method of a selected controller
                            return $this->controller->actionIndex();
                        }
                    }
                }
            }
        }

        return $this->renderErrorResponse();
    }

    public function isValidControllerOrAction($value): bool|int
    {
        if (!empty($value)) {
            return preg_match('%^[a-z][a-z0-9\\-_]*$%', $value);
        }

        return true;
    }

    public function renderErrorResponse()
    {
        http_response_code(404);
        $page = new \app\controllers\IndexController();
        return $page->actionError();
    }

    private function splitUrl(): void
    {
        if (isset($_GET['url'])) {
            // split URL
            $url = trim($_GET['url'], '/');
            $this->url_route = filter_var($url, FILTER_SANITIZE_URL);
            $url_parts = explode('/', $this->url_route);

            // Put URL parts into according properties
            $this->url_controller = $url_parts[0] ?? '';
            $this->url_action = $url_parts[1] ?? '';

            // Remove controller and action from the split URL
            unset($url_parts[0], $url_parts[1]);

            // Rebase array keys and store the URL params
            $this->url_params = array_values($url_parts);

            // for debugging. uncomment this if you have problems with the URL
            //echo 'Controller: ' . $this->url_controller . '<br>';
            //echo 'Action: ' . $this->url_action . '<br>';
            //echo 'Parameters: ' . print_r($this->url_params, true) . '<br>';
        }
    }
}
