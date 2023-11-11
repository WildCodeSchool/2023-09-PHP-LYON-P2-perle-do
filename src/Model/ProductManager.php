<?php

namespace App\Model;

use PDO;

class ProductManager extends AbstractManager
{
    public function getProductsByCategoryAndMaterial($categoryId, $materialId): array|false
    {
        $sql = "SELECT p.name AS productName, c.id AS categoryId, m.id AS materialId, p.price, 
        p.reference AS referenceProduct, c.name AS categoryName, m.name AS materialName FROM product p
        JOIN category c ON c.id=p.id_category
        JOIN material m ON m.id=p.id_material
        WHERE c.id=:categoryId AND m.id=:materialId";
        $query = $this->pdo->prepare($sql);
        $query->bindValue("categoryId", $categoryId, PDO::PARAM_INT);
        $query->bindValue("materialId", $materialId, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
