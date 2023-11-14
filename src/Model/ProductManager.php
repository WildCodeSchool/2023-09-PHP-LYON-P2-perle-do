<?php

namespace App\Model;

use PDO;

class ProductManager extends AbstractManager
{
    public const TABLE = 'product';
    public function getProductsByCategoryAndMaterial($categoryId, $materialId): array|false
    {
        $sql = "SELECT p.id, p.name AS productName, c.id AS categoryId, m.id AS materialId, p.price, 
        p.reference AS referenceProduct, c.name AS categoryName, m.name AS materialName, p.description
        FROM product p
        JOIN category c ON c.id=p.id_category
        JOIN material m ON m.id=p.id_material
        WHERE c.id=:categoryId AND m.id=:materialId";
        $query = $this->pdo->prepare($sql);
        $query->bindValue("categoryId", $categoryId, PDO::PARAM_INT);
        $query->bindValue("materialId", $materialId, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertProduct(array $product): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`name`, `reference`, 
        `price`, `description`, `origin`, `quantity`, `picture`, `id_category`, `id_material`) 
        VALUES (:name, :reference, :price, :description, :origin, :quantity, :picture, :id_category, 
        :id_material)");
        $statement->bindValue(':name', $product['name'], PDO::PARAM_STR);
        $statement->bindValue(':reference', $product['reference'], PDO::PARAM_STR);
        $statement->bindValue(':price', $product['price'], PDO::PARAM_INT);
        $statement->bindValue(':description', $product['description'], PDO::PARAM_STR);
        $statement->bindValue(':origin', $product['origin'], PDO::PARAM_STR);
        $statement->bindValue(':quantity', $product['quantity'], PDO::PARAM_INT);
        $statement->bindValue(':picture', $product['picture'], PDO::PARAM_STR);
        $statement->bindValue(':id_category', $product['id_category'], PDO::PARAM_INT);
        $statement->bindValue(':id_material', $product['id_material'], PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function getProductById(int $id): array|false
    {
        $sql = 'SELECT p.id, p.name productname, p.reference, p.price, p.description, p.origin, 
        p.quantity, p.picture, c.name categoryName, m.name materialName
        FROM product p JOIN category c ON p.id_category = c.id
        JOIN material m ON p.id_material = m.id
        WHERE p.id=:id';
        $query = $this->pdo->prepare($sql);
        $query->bindValue('id', $id, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetch();
    }
}
