<?php

namespace Database\Statement;

use Database\Connection\Connection;

/**
 * @author Guilherme P. Nogueira <guilhermenogueira90@gmail.com>
 */
class Statement implements StatementInterface
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @inheritdoc
     */
    public function fetchAll(
        string $sql,
        string $class,
        array $parameters = []
    ) : array {
        $connection = $this->connection->getConnection();

        $statement = $connection->prepare($sql);
        $statement->execute($parameters);

        return $statement->fetchAll(\PDO::FETCH_CLASS, $class);
    }

    /**
     * @inheritdoc
     */
    public function fetchObject(
        string $sql,
        string $class,
        array $parameters
    ) {
        $connection = $this->connection->getConnection();

        $statement = $connection->prepare($sql);
        $statement->execute($parameters);

        return $statement->fetchObject($class);
    }

    /**
     * @return \PDO
     */
    public function getConnection(): \PDO
    {
        return $this->connection->getConnection();
    }
}
