<?php

namespace App\Model;

use PDO;

class MaterialManager extends AbstractManager
{
    public const TABLE = 'material';

    public function getAllMaterial(): array|false
    {
            $sql = 'SELECT DISTINCT m.name materialName, c.name category FROM material as m
                JOIN product as p ON m.id = p.id_material
                JOIN category as c ON c.id = p.id_category
                WHERE c.id=p.id_category';

            $query = $this->pdo->prepare($sql);
            $query->execute();
            $materials =  $query->fetchAll(PDO::FETCH_ASSOC);

            return $materials;
    }
    public function getMaterialById(int $id): array|false
    {
            $sql = 'SELECT DISTINCT m.name, c.name FROM material as m
                JOIN product as p ON m.id = p.id_material
                JOIN category as c ON c.id = p.id_category
                WHERE c.id=:p.id_category';

            $query = $this->pdo->prepare($sql);
            $query->bindValue('id', $id, PDO::PARAM_INT);
            $query->execute();

            return $query->fetch();
    }
}
