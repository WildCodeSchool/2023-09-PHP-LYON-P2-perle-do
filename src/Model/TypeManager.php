<?php

namespace App\Model;

use PDO;

class TypeManager extends AbstractManager
{
    public const TABLE = 'type';

    public function getTypeById(int $id): array|false
    {
        $sql = 'SELECT c.id, c.civility, c.lastname, c.firstname, c.reference, 
        c.adress, c.zipcode, c.city, c.phone, c.email, c.description, c.created_date, t.type, t.discount
        FROM customer c JOIN `type` t ON c.id_type = t.id WHERE c.id=:id';
        $query = $this->pdo->prepare($sql);
        $query->bindValue('id', $id, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetch();
    }

    public function selectAll(string $orderBy = 'type', string $direction = 'ASC'): array
    {
        $query = 'SELECT * FROM ' . static::TABLE;
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        return $this->pdo->query($query)->fetchAll();
    }
}
