<?php

namespace Database\Connection;

use Database\Connection\Exception\ConnectionException;

/**
 * @author Guilherme P. Nogueira <guilhermenogueira90@gmail.com>
 */
class Connection implements ConnectionInterface
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @param string $db
     * @param string $host
     * @param string $username
     * @param string $password
     *
     * @throws ConnectionException
     */
    public function __construct(
        string $db,
        string $host,
        string $username,
        string $password
    ) {
        try {
            $this->pdo = new \PDO(
                'mysql:dbname=' .$db. ';host=' . $host . ';charset=utf8',
                $username,
                $password,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_PERSISTENT => true
                ]
            );
        } catch (\Exception $e) {
            throw ConnectionException::connectionRefused($e->getMessage());
        }
    }

    /**
     * @return bool
     */
    public function isConnected(): bool
    {
        return $this->pdo !== null;
    }

    /**
     * @return \PDO
     */
    public function getConnection(): \PDO
    {
        return $this->pdo;
    }
}
