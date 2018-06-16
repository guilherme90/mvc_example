<?php

namespace Core\Service;

use Database\Statement\StatementInterface;

/**
 * @author Guilherme P. Nogueira <guilhermenogueira90@gmail.com>
 */
abstract class AbstractStatementService
{
    /**
     * @var StatementInterface
     */
    protected $statement;

    /**
     * @param StatementInterface $statement
     */
    public function __construct(StatementInterface $statement)
    {
        $this->statement = $statement;
    }
}
