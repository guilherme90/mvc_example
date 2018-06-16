<?php

namespace Core\View\Exception;

/**
 * @author Guilherme P. Nogueira <guilhermenogueira@univicosa.com.br>
 */
class ViewException extends \Exception
{
    /**
     * @return ViewException
     */
    public static function errorRenderer() : self
    {
        return new self('could not render the template.');
    }

    /**
     * @return ViewException
     */
    public static function templateNotFound() : self
    {
        return new self('Template not found!');
    }
}
