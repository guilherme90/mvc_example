<?php

namespace Database\Connection\Exception;

/**
 * @author Guilherme P. Nogueira <guilhermenogueira90@gmail.com>
 */
class ConnectionException extends \Exception
{
    /**
     * @param string $message
     * @return ConnectionException
     */
    public static function connectionRefused(string $message) : self
    {
        return new self("Connection has refused: \n{$message}");
    }
}
