<?php

namespace Alura\Pdo\Infra\Repository;

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;

class PdoStudentRepository implements StudentRepository
{

    private \PDO $pdo;

    public function __construct(\PDO $connection)
    {
        $this->pdo = $connection;
    }

    public function allStudents(): array 
    {
        $statement = $this->pdo->query('SELECT * FROM students');
        return $statement->fetchAll();
    }
    
    public function studentsBirthAt(\DateTimeInterface $birthDate)
    {
        
    }
    public function save(Student $student): bool
    {

        $sqlInsert = "INSERT INTO studenta(name, birth_date) VALUES (?, ?)";

        $statement = $this->pdo->prepare($sqlInsert);

        $statement->bindValue(1, $student->name());
        $statement->bindValue(2, $student->birthDate()->format('Y-m-d'));

        
        return $statement->execute();
    }

    public function remove(Student $student): bool
    {
        return true;
    }
}