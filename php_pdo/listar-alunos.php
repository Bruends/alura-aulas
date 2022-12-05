<?php
require_once 'vendor/autoload.php';

use Alura\Pdo\Infra\Persistence\ConnectionCreator;

$pdo = ConnectionCreator::createConnection();

$statement = $pdo->query('SELECT * FROM students');
$res = $statement->fetchAll(PDO::FETCH_ASSOC);

var_dump($res);