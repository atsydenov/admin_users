<?php

/**
 * Class Router
 * Front controller.
 */
class Router {

    /**
     * @var array
     */
    private $routes;

    /**
     * Path to available routes.
     */
    CONST ROUTES_PATH = ROOT . '/config/routes.php';

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $routePath = self::ROUTES_PATH;
        $this->routes = include($routePath);
    }

    /**
     * Return current request.
     * @return string
     */
    private function getURI()
    {
        $result = (!empty($_SERVER['REQUEST_URI'])) ? trim($_SERVER['REQUEST_URI'], '/') : '';
        return $result;
    }

    /**
     * Find controller and action.
     */
    public function run()
    {
        $uri = $this->getURI();

        foreach ($this->routes as $uriPattern => $path) {

            if (preg_match("~$uriPattern~", $uri)) {

                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                $segments = explode('/', $internalRoute);

                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action' . ucfirst(array_shift($segments));
                $parameters = $segments;

                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    include_once ($controllerFile);
                }

                $controllerObject = new $controllerName();
                
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                if ($result != NULL) {
                    break;
                }
            }
        }
    }
}
