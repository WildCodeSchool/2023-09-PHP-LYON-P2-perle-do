<?php

namespace App\Model;

use PDO;

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
        $statement->bindValue(':name', $credentials['name']);
        $statement->bindValue(':pseudo', $credentials['pseudo']);
        $statement->bindValue(':password', password_hash($credentials['password'], PASSWORD_DEFAULT));
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

    public function update(array $user): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `pseudo` = :pseudo WHERE id=:id");
        $statement->bindValue('id', $user['id'], PDO                      ::PARAM_INT);
        $statement->bindValue('pseudo', $user['pseudo'], PDO::PARAM_STR);

        return $statement->execute();
    }
}
