<?php

namespace App\Model;

use PDO;

class CategoryManager extends AbstractManager
{
    public const TABLE = 'category';

    public function addCategory(array $category): int
    {
            $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . "(`name`) VALUES (:name)");
            $statement->bindValue(':name', $category['name'], PDO::PARAM_STR);
            $statement->execute();
             return (int)$this->pdo->lastInsertId();
    }
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . static::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, PDO::PARAM_INT);
        $statement->execute();
    }
}
