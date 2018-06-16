<?php

namespace Database\Statement;

/**
 * @author Guilherme P. Nogueira <guilhermenogueira90@gmail.com>
 */
interface StatementInterface
{
    /**
     * @param string $sql
     * @param string $class
     * @param array  $parameters
     * @return array
     */
    public function fetchAll(
        string $sql,
        string $class,
        array $parameters = []
    ) : array;

    /**
     * @param string $sql
     * @param string $class
     * @param array  $parameters
     * @return mixed
     */
    public function fetchObject(
        string $sql,
        string $class,
        array $parameters
    );

    /**
     * @return \PDO
     */
    public function getConnection() : \PDO;
}
