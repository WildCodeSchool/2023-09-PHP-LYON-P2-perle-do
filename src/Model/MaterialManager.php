<?php

namespace App\Model;

use PDO;

class MaterialManager extends AbstractManager
{
    public const TABLE = 'material';

    public function getAllMaterial($categoryId): array|false
    {
            $sql = "SELECT DISTINCT m.name materialName, m.id materialId, c.id categoryId,
            c.name categoryName FROM material as m
                JOIN product as p ON m.id = p.id_material
                JOIN category as c ON c.id = p.id_category
                WHERE c.id=:categoryId";

            $query = $this->pdo->prepare($sql);
            $query->bindValue('categoryId', $categoryId, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getMaterialById(int $id): array|false
    {
            $sql = 'SELECT DISTINCT m.name materialsName,c.id categoryId, c.name categoryName FROM material as m
                JOIN product as p ON m.id = p.id_material
                JOIN category as c ON c.id = p.id_category
                WHERE c.id=:p.id_category';

            $query = $this->pdo->prepare($sql);
            $query->bindValue('id', $id, PDO::PARAM_INT);
            $query->execute();

            return $query->fetch();
    }

    public function addMaterial(array $material): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . "(`name`) VALUES (:name)");
        $statement->bindValue(':name', $material['name'], PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function updateMaterial(array $material): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `id` = :id, `name` = :name
        WHERE id=:id");
        $statement->bindValue('id', $material['id'], PDO::PARAM_INT);
        $statement->bindValue('name', $material['name'], PDO::PARAM_STR);

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
