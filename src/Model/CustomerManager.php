<?php

namespace App\Model;

use PDO;

class CustomerManager extends AbstractManager
{
    public const TABLE = 'customer';

    public function getAll(): array | bool
    {
        $sql = 'SELECT c.civility, c.lastname, c.firstname, 
        c.reference, c.adress, c.zipcode, c.city, c.phone, c.email, c.description, c.created_date, t.type
        FROM customer c JOIN type t ON c.id_type = t.id';
        $query = $this->pdo->prepare($sql);
        $query->execute();
        $cust = $query->fetchAll(PDO::FETCH_ASSOC);
        return $cust;
    }

    /**
     * Insert new customer in database
     */
    public function insert(array $customer): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`civility`, `lastname`, 
        `firstname`, `reference`, `adress`, `zipcode`, `city`, `phone`, `email`, `description`, `created_date) 
        VALUES (:civility, :lastname, :firstname, :reference, :adress, :zipcode, :city, :phone, 
        :email, :description, :created_date)");
        $statement->bindValue('civility', $customer['civility'], PDO::PARAM_STR);
        $statement->bindValue('lastname', $customer['lastname'], PDO::PARAM_STR);
        $statement->bindValue('firstname', $customer['firstname'], PDO::PARAM_STR);
        $statement->bindValue('reference', $customer['reference'], PDO::PARAM_STR);
        $statement->bindValue('adress', $customer['adress'], PDO::PARAM_STR);
        $statement->bindValue('zipcode', $customer['zipcode'], PDO::PARAM_INT);
        $statement->bindValue('city', $customer['city'], PDO::PARAM_STR);
        $statement->bindValue('phone', $customer['phone'], PDO::PARAM_INT);
        $statement->bindValue('email', $customer['email'], PDO::PARAM_STR);
        $statement->bindValue('description', $customer['description'], PDO::PARAM_STR);
        $statement->bindValue('create_date', $customer['created_date'], PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Update item in database
     */
    public function update(array $customer): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `civility` = :civility, 
        `lastname` = :lastname, `firstname` = :firstname, `reference` = :reference, 
        `adress` = :adress,`zipcode` = :zipcode,`city` = :city, `phone` = :phone, 
        `email` = :email,`description` = :description, `created_date` = :created_date WHERE id=:id");
        $statement->bindValue('id', $customer['id'], PDO::PARAM_INT);
        $statement->bindValue('civility', $customer['civility'], PDO::PARAM_STR);
        $statement->bindValue('lastname', $customer['lastname'], PDO::PARAM_STR);
        $statement->bindValue('firstname', $customer['firstname'], PDO::PARAM_STR);
        $statement->bindValue('reference', $customer['reference'], PDO::PARAM_STR);
        $statement->bindValue('adress', $customer['adress'], PDO::PARAM_STR);
        $statement->bindValue('zipcode', $customer['zipcode'], PDO::PARAM_INT);
        $statement->bindValue('city', $customer['city'], PDO::PARAM_STR);
        $statement->bindValue('phone', $customer['phone'], PDO::PARAM_INT);
        $statement->bindValue('email', $customer['email'], PDO::PARAM_STR);
        $statement->bindValue('description', $customer['description'], PDO::PARAM_STR);
        $statement->bindValue('create_date', $customer['created_date'], PDO::PARAM_STR);

        return $statement->execute();
    }
}
