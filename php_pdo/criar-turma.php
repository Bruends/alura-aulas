<?php

require __DIR__ . '/vendor/autoload.php';

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infra\Persistence\ConnectionCreator;
use Alura\Pdo\Infra\Repository\PdoStudentRepository;

$connection = ConnectionCreator::createConnection();

$repository = new PdoStudentRepository($connection);


$connection->beginTransaction();
try {
    $s1 = new Student(null, 'Bruno', new \DateTimeImmutable('1996-05-06'));
    $repository->save($s1);

    $s2 = new Student(null, 'Thayna', new \DateTimeImmutable('1997-01-10'));
    $repository->save($s2);

    $connection->commit();
} catch (\PDOException $e) {
    echo $e->getMessage();
    $connection->rollBack();
}

