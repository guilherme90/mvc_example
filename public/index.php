<?php

/**
 * @author Guilherme P. Nogueira <guilhermenogueira90@gmail.com>
 */

/** Force type hint ~7.0 */
declare(strict_types = 1);

/** Defaults configuration */
setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
error_reporting(E_ALL);
ini_set('display_errors', 'true');

chdir(dirname(__DIR__));

require_once './vendor/autoload.php';

$config = require_once './config/database.config.php';

use \Database\Connection\Connection;
use \Database\Statement\MySQLStatement;

$connection = new Connection(
    $config['dbname'],
    $config['hostname'],
    $config['username'],
    $config['password']
);

$statement = new MySQLStatement($connection);

$application = new \Core\Application($statement);
$application->run();
