<?php

namespace Core\Controller;

use Core\Service\AbstractStatementService;
use Core\View\View;

/**
 * @author Guilherme P. Nogueira <guilhermenogueira90@gmail.com>
 */
abstract class AbstractController extends AbstractStatementService
{
    /**
     * @param string $template
     * @param array  $data
     * @return View
     * @throws \Core\View\Exception\ViewException
     */
    public function render(string $template, array $data = [])
    {
        $view = new View($template, $data);

        return $view;
    }

    /**
     * @param array $data
     *
     * @return string
     */
    public function jsonResponse(array $data)
    {
        header('Content-Type: application/json');

        echo json_encode($data);
    }

    /**
     * @return bool
     */
    public function isGet() : bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getRawBody() : array
    {
        $contentType = $_SERVER['CONTENT_TYPE'];

        if ($contentType !== 'application/json') {
            throw new \Exception('Content-Type invalid!');
        }

        $content = trim(file_get_contents('php://input'));
        $decoded = json_decode($content, true);

        if (! is_array($decoded)) {
            throw new \Exception('Invalid JSON!');
        }

        return $decoded;
    }

    /**
     * @return array
     */
    public function getQueryParams() : array
    {
        $params = explode('?', $_SERVER['QUERY_STRING']);
        $params = explode('=', $params[0]);

        $keys = [];
        $values = [];
        foreach ($params as $key => $param) {
            if ($key % 2 === 0) {
                $keys[] = $param;
            }

            if ($key % 2 === 1) {
                $values[] = $param;
            }
        }

        $paramsFormatted = [];
        foreach ($keys as $key) {
            foreach ($values as $value) {
                $paramsFormatted[$key] = $value;
            }
        }

        return $paramsFormatted;
    }
}
