<?php

class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Check if controller file exists
        $controllerFile = ROOT_PATH . '/app/controllers/' . ucfirst($url[0]) . 'Controller.php';
        if (file_exists($controllerFile)) {
            $this->controller = ucfirst($url[0]) . 'Controller';
            unset($url[0]);
        }

        require_once ROOT_PATH . '/app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Check if method exists
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // Get remaining params
        $this->params = $url ? array_values($url) : [];

        // Call the method with params
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }

        // For PHP built-in server: parse REQUEST_URI
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Strip base script directory if app is in a subdirectory
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
        if ($scriptDir !== '/' && $scriptDir !== '\\') {
            if (strpos($requestUri, $scriptDir) === 0) {
                $requestUri = substr($requestUri, strlen($scriptDir));
            }
        }

        $requestUri = trim($requestUri, '/');

        if (!empty($requestUri)) {
            return explode('/', filter_var($requestUri, FILTER_SANITIZE_URL));
        }

        return ['home']; // default
    }
}
