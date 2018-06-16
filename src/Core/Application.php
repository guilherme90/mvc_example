<?php

namespace Core;

use Core\Controller\AbstractController;
use Database\Connection\Connection;
use Database\Statement\Statement;
use Database\Statement\StatementInterface;
use Home\Controllers\HomeController;

/**
 * @author Guilherme P. Nogueira <guilhermenogueira90@gmail.com>
 */
class Application
{
    /**
     * @var StatementInterface
     */
    private $statement;

    /**
     * @param StatementInterface $statement
     */
    public function __construct(StatementInterface $statement)
    {
        $this->statement = $statement;
    }

    /**
     * @param string $uri
     * @throws \Exception
     */
    private function checkControllerClass(string $uri)
    {
        $uri = explode('/', $uri);

        $controllerName = ucfirst($uri[1]);
        $module = getcwd() . '/src/' . $controllerName;

        if (! is_dir($module)) {
            throw new \Exception(
                sprintf('Module "%s" does not exists!', $module)
            );
        }

        $controllerClass = $module . '/Controllers/' . $controllerName . 'Controller';

        if (! file_exists($controllerClass . '.php')) {
            throw new \Exception(
                sprintf('Controller file "%s" does not exists!', $controllerClass)
            );
        }

        if (! class_exists('\\' . $controllerName . '\\Controllers\\' . $controllerName . 'Controller')) {
            throw new \Exception(
                sprintf('Controller class "%s" does not exists!', $controllerClass)
            );
        }

        $reflection = new \ReflectionClass('\\' . $controllerName . '\\Controllers\\' . $controllerName . 'Controller');
        $controller = $reflection->newInstance($this->statement);

        $this->checkActionController($controller, $uri);
    }

    /**
     * @param AbstractController $controller
     * @param array              $uri
     *
     * @return mixed|void
     * @throws \Exception
     */
    private function checkActionController(AbstractController $controller, array $uri)
    {
        if (!isset($uri[2])) {
            $controller->indexAction();

            return;
        }

        $action = $uri[2];
        $action = $action . 'Action';

        try {
            $reflectionMethod = new \ReflectionMethod($controller, $action);
            $reflectionMethod->invoke(new $controller($this->statement));
        } catch (\Exception $e) {
            throw new \Exception(
                sprintf(
                    'Action "%s" in Controller "%s" does not exists!',
                    $action,
                    (new \ReflectionClass($controller))->getName()
                )
            );
        }
    }

    /**
     * @return void
     */
    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];

        if ($uri !== '/') {
            $this->checkControllerClass($uri);

            return;
        }

        $controller = new HomeController($this->statement);
        $controller->indexAction();
    }
}
