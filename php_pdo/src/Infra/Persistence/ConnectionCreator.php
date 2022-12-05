<?php

namespace Alura\Pdo\Infra\Persistence;

class ConnectionCreator
{
    public static function createConnection(): \PDO 
    {
        $dbPath = __DIR__ . '/../../../banco.sqlite';

        $pdo = new \PDO('sqlite:' . $dbPath);
        
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        return $pdo;
    }
}