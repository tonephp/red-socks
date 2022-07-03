<?php

namespace core;

use Exception;

class Router {
    protected static $routes = [];
    protected static $route = [];
    protected static $url = '';
    protected static $controllerObj;
    protected static $exceptionCode = DEBUG ? 500 : 404;

    public static function add($regexp, $route = []) {
        self::$routes[$regexp] = $route;
    }

    public static function dispatch($url) {
        self::$url = $url;
        $url = self::removeQueryString($url);
        
        if (self::matchRoute($url)) {
            
            $controllerName = self::getControllerName();
            self::loadController($controllerName);

            if (self::$controllerObj) {
                
                
                $actionName = self::getActionName();
                self::callAction($actionName);

                self::$controllerObj->getView();

                unset($_SESSION['errors']);
                unset($_SESSION['success']);
            }
        } else {
            self::handleCustomErrorPage("Page not found. URL: $url");
        }
    }

    public static function getRoutes() {
        return self::$routes;
    }

    public static function getRoute() {
        return self::$route;
    }

    protected static function matchRoute($url) {
        
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#$pattern#i", $url, $matches)) {
                
                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $route[$k] = $v;
                    }
                }

                if (!isset($route['action'])) {
                    $route['action'] = 'index';
                }

                if (!isset($route['prefix'])) {
                    $route['prefix'] = '';
                } else {
                    $route['prefix'] .= '\\';
                }

                $route['controller'] = upperCamelCase($route['controller']);
                $route['url'] = $url;

                self::$route = $route;

                return true;
            }
        }
        
        return false;
    }

    protected static function getControllerName() {
        $name = self::$route['prefix'] . self::$route['controller'] . 'Controller';
        $name = 'app\controllers\\' . $name;

        return $name;
    }

    protected static function getErrorControllerName() {
        $name = (self::$route['prefix'] ?? '') . 'ErrorController';
        $name = 'app\controllers\\' . $name;

        return $name;
    }

    protected static function getActionName() {
        $name = self::$route['action'];
        $name = lowerCamelCase($name);
        $name = $name . 'Action';

        return $name;
    }

    protected static function loadController($name) {
        if (class_exists($name)) {
            self::$controllerObj = new $name(self::$route);
        } else {
            self::handleCustomErrorPage("Controller $name not exists.");
        }
    }

    protected static function callAction($name) {
        if (method_exists(self::$controllerObj, $name)) {
            self::$controllerObj->$name();
        } else {
            self::handleCustomErrorPage("Action $name not exists.");
        }
    }

    protected static function handleCustomErrorPage($logMessage = 'Some error in handleCustomErrorPage') {
        $errorControllerName = self::getErrorControllerName();

        if (!DEBUG && class_exists($errorControllerName)) {
            self::$route['controller'] = 'Error';
            self::$route['action'] = 'index';
            self::$route['prefix'] = self::$route['prefix'] ?? '';
            self::$route['url'] = self::$route['url'] ?? self::$url;
        
            self::$controllerObj = new $errorControllerName(self::$route);
            $actionName = self::getActionName();
            self::$controllerObj->$actionName();
            self::$controllerObj->getView();

            ErrorHandler::logError($logMessage, 'Router.php', '');

            die;
        } else {
            $url = isset(self::$route['url']) && self::$route['url'];
            throw new Exception("$logMessage. URL: $url", self::$exceptionCode);
        }
    }

    protected static function removeQueryString($url) {
        
        if ($url) {
            $params = explode('&', $url);
            $urlCandidate = $params[0];

            if (false === strpos($urlCandidate, '=')) {
                return rtrim($urlCandidate, '/');
            }
        }

        return '';
    }
}
