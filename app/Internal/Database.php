<?php

namespace App\Internal;

use App\Exceptions\Database\ConnectionFailureException;

class Database
{
    /**
     * @var \PDO
     */
    public readonly \PDO $pdo;

    /**
     * @return void 
     * 
     * @throws ConnectionFailure 
     */
    public function __construct() 
    {
        $this->pdo = new \PDO(
            app()->config->get('database.dsn'), 
            app()->config->get('database.user'), 
            app()->config->get('database.pass'),
            app()->config->get('database.options')
        ) ?: throw new ConnectionFailureException(code: 503);

        $this->pdo->exec('set names '.app()->config->get('database.charset').'
                          collate '.app()->config->get('database.collation'));
    }
}