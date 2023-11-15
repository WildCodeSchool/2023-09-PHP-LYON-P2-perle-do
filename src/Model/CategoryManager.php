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
    public function updateCategory(array $category): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `id` = :id, `name` = :name
        WHERE id=:id");
        $statement->bindValue('id', $category['id'], PDO::PARAM_INT);
        $statement->bindValue('name', $category['name'], PDO::PARAM_STR);

        return $statement->execute();
    }

    public function selectAll(string $orderBy = 'name', string $direction = 'ASC'): array
    {
        $query = 'SELECT * FROM ' . static::TABLE;
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        return $this->pdo->query($query)->fetchAll();
    }
}
