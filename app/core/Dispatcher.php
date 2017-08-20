<?php

/**
 * Description of Dispatcher
 *
 * @author Serba
 */
class Dispatcher {



    protected static $routes = [];
    protected static $route = [];
    protected static $page;
    
    public static function add($regexp, $route = []) {
        self::$routes[$regexp] = $route;
    }

    public static function getRoutes() {
        return self::$routes;
    }

    public static function getRoute() {
        return self::$route;
    }
    
    public static function debug($arr) {
    echo '<pre>' .print_r($arr, true).  '</pre>';
    }

    public static function matchRoute($url) {

        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#$pattern#i", $url, $matches)) {
                foreach ($matches as $k => $v) {
                    if (is_string('method')){
                        $route['method'] = $v;
                    }
                }
                self::$route = $route;
                self::$page = $route['method'];
                return true;
            }
        }
        return false;
    }
    
    /**
     * Перенаправляет URL по корректному маршруту
     * @param string $url входящий URL
     * @return void
     */
    
    public static function dispatch($url) {
        $url = explode("&", $url);
        $url = $url[0];
        if(self::matchRoute($url)) {
            if (class_exists('SerbinController')) {
                $controller_method = self::$page.'Action';
                if(method_exists('SerbinController', $controller_method)){
                    $SCobj = new SerbinController();
                    $SCobj->$controller_method();
                }else{
                    echo "Метод <b>$controller_method</b> в контроллере SerbinController не найден";
//                  http_response_code(404);
//                  include '404.html';
                }  
            }else{
                echo 'Класс SerbinController не найден';
            }

        }else {
            echo "</br>Что то не так....";
            http_response_code(404);
            include '404.html';
        }  
    }

}
