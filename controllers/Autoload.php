<?php

class Autoload
{
    public function __construct()
    {
        spl_autoload_register(function ($class) {
            $path_controllers = 'controllers/' . $class . '.php';
            $path_models = 'models/' . $class . '.php';
            if (file_exists($path_models)) require_once($path_models);
            if (file_exists($path_controllers)) require_once($path_controllers);
        });
    }
}