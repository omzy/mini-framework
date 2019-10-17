<?php

namespace mini\core;

use Mini;

class Console
{
    public $base_path;
    public $app_path;

    public $url_controller = null;
    public $url_action = null;

    public $controller;
    public $action;

    public function __construct($config)
    {
        Mini::$app = $this;

        $this->configure($this, $config);
        $this->setBasePath($config['base_path']);
        $this->setAppPath();
        $this->setupErrorReporting($config['app_debug']);
    }

    public function setBasePath($path)
    {
        $this->base_path = $path;
    }

    public function getBasePath()
    {
        return $this->base_path;
    }

    public function setAppPath()
    {
        $this->app_path = $this->getBasePath() . DIRECTORY_SEPARATOR . 'app';
    }

    public function getAppPath()
    {
        return $this->app_path;
    }

    public function configure($object, $properties)
    {
        foreach ($properties as $name => $value) {
            $object->$name = $value;
        }

        return $object;
    }

    public function setupErrorReporting($app_debug)
    {
        if ($app_debug == true) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }
    }

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

    private function splitUrl()
    {
        global $argc, $argv;

        if (isset($argc)) {
            if (isset($argv[1])) {
                $this->url_action = $argv[1] ?? null;
            }
        }
        else {
            echo "argc and argv disabled\n";
        }
    }
}
