<?php

namespace App\Model;

use PDO;

class ProductManager extends AbstractManager
{
    public function selectProductByCategoryAndMaterial($categoryId, $materialId): array|false
    {
        $sql = "SELECT * FROM product p
        JOIN category c ON c.id=p.id_category
        JOIN material m ON m.id=p.id_material
        WHERE c.id=:p.id_category AND m.id=:p.id_material";
        $query = $this->pdo->prepare($sql);
        $query->bindValue("p.id_category", $categoryId, PDO::PARAM_INT);
        $query->bindValue("p.id_material", $materialId, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch();
    }
}
