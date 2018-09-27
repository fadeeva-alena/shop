<?php
/**
 * Created by PhpStorm.
 * User: Алёна
 * Date: 06.08.2018
 * Time: 13:15
 */

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath=ROOT.'/config/routes.php';
        $this->routes = include($routesPath);
    }
    private function getUri(){
        if(!empty($_GET['url'])){
            return $_GET['url'];
        }
    }
    public function run(){
        //получить строку запроса
        $uri=$this->getUri();
        //проверить наличие такого запроса в routes.php
        foreach ($this->routes as $uriPattern => $path){
            if (preg_match("~^$uriPattern$~", $uri)){
                //если есть совпадение, проверить какой controller и action
                //обрабатывают запрос

                //получаем внутренний путь из внешнего согласно правилу
                //если 3 подпадает под шаблон 1, то в 2 подставляются параметры из 3
                $internalRoute = preg_replace("~^$uriPattern$~", $path, $uri);
                $segments = explode('/', $internalRoute);
                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action'.ucfirst(array_shift($segments));

                $parameters=$segments;

                //подключить класс файла-контроллера
                $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';
                if(file_exists($controllerFile)){
                    include_once($controllerFile);
                }

                //создать обьект, вызвать метож(то есть асtion)
                $controllerObject = new $controllerName;
                //обычный вызов метода у обьекта, отличие в передачи параметров
                $result = call_user_func_array(array($controllerObject,$actionName), $parameters);

                if($result != null){
                    break;
                }
            }
        }

    }
}