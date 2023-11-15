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
}
