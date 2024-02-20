<?php
namespace public\src\Libs\Controllers;

use Config\ProjectSettings;
use public\src\Libs\Https\Request;
use public\src\Libs\Https\Response;
use public\src\Libs\Views\View;

class Controller
{
    protected Request $_request;

    public function __construct()
    {
        $this->_request = Request::instance();
    }

    public function run($action, $params = [])
    {
        if (!method_exists($this, $action)) {
            return $this->render404("Page not found.");
        }
        return $this->$action($params);
    }

    protected function render(string $file_path_after_templates_dir, array $data = []): Response
    {
        $view = new View();
        return new Response($view->render($file_path_after_templates_dir, $data));
    }


    protected function redirect($uri)
    {
        return Response::redirect($uri);
    }

    protected function render404($message='Page not found.')
    {
        $controller = ProjectSettings::NOT_FOUND_CONTROLLER;
        $controller = new $controller($message);
        return $controller->index([]);
    }
}