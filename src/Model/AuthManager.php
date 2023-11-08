<?php

namespace App\Model;

class AuthManager extends AbstractManager
{
    public const TABLE = 'user';

    public function selectOneByLogin(string $pseudo): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE pseudo=:pseudo");
        $statement->bindValue('pseudo', $pseudo, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }

    public function insert(array $credentials): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . static::TABLE .
            " (`lastname`, `name`, `pseudo`, `password`, `role`)
        VALUES (:lastname, :name, :pseudo, :password, :role)");
        $statement->bindValue(':lastname', $credentials['lastname']);
        $statement->bindValue(':name', password_hash($credentials['name'], PASSWORD_DEFAULT));
        $statement->bindValue(':pseudo', $credentials['pseudo']);
        $statement->bindValue(':password', $credentials['password']);
        $statement->bindValue(':role', $credentials['role']);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function selectOneById(int $id): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }
}
