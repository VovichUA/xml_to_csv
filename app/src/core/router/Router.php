<?php

namespace Src\Core\Router;

use Closure;
use Src\Libs\Services\Response;
use Src\Libs\Services\Request;

class Router
{
    /**
     * @var array
     */
    private $routes = [];

    private $requestedMethod;

    /**
     * @var Closure
     */
    private $notFoundAction;

    private $appBasePath;

    private $response;

    private $request;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->notFoundAction = function($url){
            echo "{$url} is not found";
        };
    }

    /**
     * @param Closure $action
     */
    public function setNotFoundAction(Closure $action)
    {
        $this->notFoundAction = $action;
    }

    /**
     * @param string $pattern
     * @param string $action
     */
    public function get(string $pattern,string $action)
    {
        $this->add('GET', $pattern, $action);
    }

    /**
     * @param string $pattern
     * @param string $action
     */
    public function post(string $pattern,string $action)
    {
        $this->add('POST', $pattern, $action);
    }

    /**
     * @param string $method
     * @param string $pattern
     * @param string $action
     */
    public function add(string $method,string $pattern,string $action)
    {
        $pattern =  rtrim($pattern, '/') == '' ? '/' : rtrim($pattern, '/');
        $this->routes[$method][$pattern] =  $action;
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function run()
    {
        $this->requestedMethod = $this->getRequestMethod();

        $this->request = new Request();

        if(isset($this->routes[$this->requestedMethod])){
            $this->handle($this->routes[$this->requestedMethod]);
        }else{
            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
        }
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        $uri = substr($_SERVER['REQUEST_URI'], strlen($this->getAppBasePath()));

        if(strstr($uri, '?')){
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        return '/' . trim($uri, '/');
    }

    /**
     * @param array $routes
     * @return false|mixed
     */
    public function handle(array $routes)
    {
        $uri = $this->getUri();

        Response::addValidationRedirect($this->appBasePath. ltrim($uri, '/'));
        Response::setBaseUri($this->appBasePath);

        foreach ($routes as $pattern => $actions) {

            if(preg_match('~^'. $pattern . '$~', $uri, $matches)){

                $params = array_slice($matches, 1);

                if(is_callable($actions)){
                    $action = $actions;
                } else{
                    $actions = explode('@', $actions);
                    $controller = 'App\\Controllers\\' . $actions[0];
                    $action = $actions[1];
                    $action = [(new $controller), $action];
                }

                if($this->requestedMethod == 'POST')
                    return call_user_func_array($action, [$this->request]);

                if( count($params) > 1){
                    return call_user_func_array($action, [$params]);
                }

                if( isset($params[0])){
                    return call_user_func_array($action, [$params[0]]);
                }

                return call_user_func($action);
            }
        }

        call_user_func_array($this->notFoundAction, [$uri]);
    }

    /**
     * @return string
     */
    private function getAppBasePath(): string
    {
        if($this->appBasePath === null){
            $this->appBasePath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        }

        return $this->appBasePath;
    }
}