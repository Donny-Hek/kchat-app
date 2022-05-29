<?php

class Route
{
    public static function start()
    {
        // контроллер и действие по умолчанию
        $controller_name = 'Controller_Index';
        $model_name = 'Model_Index';
        $action_name = 'index';

        $routes = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $i = count($routes) - 1;
//        echo var_dump($routes);
        while ($i > 1) {
            if ($routes[$i] != '') {
                //|| !empty($_GET)
                if (is_file("application/controllers/" . ucfirst("controller_" . $routes[$i]) . ".php")) {
                    $model_name = ucfirst('Model_' . $routes[$i]);
                    $controller_name = ucfirst('Controller_' . $routes[$i]);
                    break;
                } else {
                    $action_name = $routes[$i];
                }
            }
            $i--;
        }

        $model_path = "application/models/" . strtolower($model_name) . ".php";
        if (file_exists($model_path)) {
            require_once $model_path;
        } else {
            Route::ErrorPage404();
        }

        $controller_path = "application/controllers/" . strtolower($controller_name) . ".php";
        if (file_exists($controller_path)) {
            require_once $controller_path;
        } else {
            Route::ErrorPage404();
        }

        $controller = new $controller_name;//$controller = new Controller_Index
        $action = $action_name;//action_index
//        echo($controller_name."/".$action);
        if (method_exists($controller, $action)) {
            // вызываем действие контроллера
            $controller->$action();
        } else {
            Route::ErrorPage404();
        }

    }

    static function ErrorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }
}
