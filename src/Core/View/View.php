<?php

namespace Core\View;

use Core\View\Exception\ViewException;

/**
 * @author Guilherme P. Nogueira <guilhermenogueira90@gmail.com>
 */
class View
{
    /**
     * @var string
     */
    private $layout = 'layout';

    /**
     * @param string $template
     * @param array $data
     * @throws ViewException
     */
    public function __construct(string $template, array $data = [])
    {
        try {
            $template = getcwd() . '/public/views/' . $template . '.php';
            extract($data, EXTR_SKIP);

            ob_start();
            $include = include $template;
            $content = ob_get_clean();

            require_once getcwd() . '/public/views/' . $this->layout . '.php';
        } catch (\Exception $e) {
            ob_end_clean();
            throw ViewException::errorRenderer();
        }

        if ($include === false) {
            throw ViewException::templateNotFound();
        }
    }
}
