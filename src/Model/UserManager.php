<?php

namespace App\Model;

use PDO;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    public function update(array $user): bool
    {
        $sqlPassword = '';
        if (!empty($user['password'])) {
            $sqlPassword = "`password` = :password,";
        }

        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `pseudo` = :pseudo, " . $sqlPassword . " 
        `lastname` = :lastname, `name` = :name, `role_id` = :role_id WHERE id=:id");
        $statement->bindValue('id', $user['id'], PDO::PARAM_INT);
        $statement->bindValue('pseudo', $user['pseudo'], PDO::PARAM_STR);

        if (!empty($sqlPassword)) {
            $statement->bindValue(':password', password_hash($user['password'], PASSWORD_DEFAULT));
        }

        $statement->bindValue(':lastname', $user['lastname']);
        $statement->bindValue(':name', $user['name']);
        $statement->bindValue(':role_id', $user['role_id']);

        return $statement->execute();
    }

    public function insert(array $credentials): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . static::TABLE .
            " (`lastname`, `name`, `pseudo`, `password`, `role_id`)
        VALUES (:lastname, :name, :pseudo, :password, :role_id)");
        $statement->bindValue(':lastname', $credentials['lastname']);
        $statement->bindValue(':name', $credentials['name']);
        $statement->bindValue(':pseudo', $credentials['pseudo']);
        $statement->bindValue(':password', password_hash($credentials['password'], PASSWORD_DEFAULT));
        $statement->bindValue(':role_id', $credentials['role_id']);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function selectOneById(int $id): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
}
