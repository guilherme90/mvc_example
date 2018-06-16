<?php

namespace Database\Connection;

/**
 * @author Guilherme P. Nogueira <guilhermenogueira90@gmail.com>
 */
interface ConnectionInterface
{
    /**
     * @return bool
     */
    public function isConnected() : bool;

    /**
     * @return \PDO
     */
    public function getConnection() : \PDO;
}
