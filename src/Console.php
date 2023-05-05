<?php

namespace Mini;

class Console
{
    public $base_path;
    public $app_path;

    public $url_controller = null;
    public $url_action = null;

    public $controller;
    public $action;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        Mini::$app = $this;

        $this->configure($this, $config);
        $this->setBasePath($config['base_path']);
        $this->setAppPath();
        $this->setupErrorReporting($config['app_debug']);
    }

    /**
     * @param string $path
     * @return void
     */
    public function setBasePath(string $path)
    {
        $this->base_path = $path;
    }

    /**
     * @return mixed
     */
    public function getBasePath()
    {
        return $this->base_path;
    }

    /**
     * @return void
     */
    public function setAppPath()
    {
        $this->app_path = $this->getBasePath() . DIRECTORY_SEPARATOR . 'app';
    }

    /**
     * @return mixed
     */
    public function getAppPath()
    {
        return $this->app_path;
    }

    /**
     * @param Console $object $object
     * @param array $properties
     * @return object
     */
    public function configure(self $object, array $properties): object
    {
        foreach ($properties as $name => $value) {
            $object->$name = $value;
        }

        return $object;
    }

    /**
     * @param bool $app_debug
     * @return void
     */
    public function setupErrorReporting(bool $app_debug)
    {
        if ($app_debug) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }
    }

    /**
     * @return mixed
     */
    public function run()
    {
        $this->splitUrl();

        $controller_name = 'CommandsController';
        $controller_class = "\\app\\controllers\\" . $controller_name;
        $this->controller = new $controller_class();

        $method_name = 'action' . str_replace(' ', '', ucwords(implode(' ', explode('-', $this->url_action))));
        $this->action = $method_name;

        return $this->controller->{$this->action}();
    }

    /**
     * @return void
     */
    private function splitUrl()
    {
        global $argc, $argv;

        if (isset($argc)) {
            if (isset($argv[1])) {
                $this->url_action = $argv[1] ?? null;
            }
        } else {
            echo "argc and argv disabled\n";
        }
    }
}
