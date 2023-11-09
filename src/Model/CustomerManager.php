<?php

namespace App\Model;

use PDO;

class CustomerManager extends AbstractManager
{
    public const TABLE = 'customer';

    public function getAllCustomer(): array | bool
    {
        $sql = 'SELECT c.id, c.civility, c.lastname, c.firstname, c.reference, 
        c.adress, c.zipcode, c.city, c.phone, c.email, c.description, c.created_date, t.type, t.discount
        FROM customer c JOIN `type` t ON c.id_type = t.id';
        $query = $this->pdo->prepare($sql);
        $query->execute();
        $customers = $query->fetchAll(PDO::FETCH_ASSOC);
        return $customers;
    }

    public function getCustomerById(int $id): array|false
    {
        $sql = 'SELECT c.id, c.civility, c.lastname, c.firstname, c.reference, 
        c.adress, c.zipcode, c.city, c.phone, c.email, c.description, c.created_date, t.type, t.discount
        FROM customer c JOIN `type` t ON c.id_type = t.id WHERE c.id=:id';
        $query = $this->pdo->prepare($sql);
        $query->bindValue('id', $id, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetch();
    }
    /**
     * Insert new customer in database
     */
    public function insert(array $customer): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`civility`, `lastname`, 
        `firstname`, `reference`, `adress`, `zipcode`, `city`, `phone`, `email`, `description`, `created_date`, 
        `id_type`) 
        VALUES (:civility, :lastname, :firstname, :reference, :adress, :zipcode, :city, :phone, 
        :email, :description, :created_date, :id_type)");
        $statement->bindValue(':civility', $customer['civility'], PDO::PARAM_STR);
        $statement->bindValue(':lastname', $customer['lastname'], PDO::PARAM_STR);
        $statement->bindValue(':firstname', $customer['firstname'], PDO::PARAM_STR);
        $statement->bindValue(':reference', $customer['reference'], PDO::PARAM_STR);
        $statement->bindValue(':adress', $customer['adress'], PDO::PARAM_STR);
        $statement->bindValue(':zipcode', $customer['zipcode'], PDO::PARAM_INT);
        $statement->bindValue(':city', $customer['city'], PDO::PARAM_STR);
        $statement->bindValue(':phone', $customer['phone'], PDO::PARAM_INT);
        $statement->bindValue(':email', $customer['email'], PDO::PARAM_STR);
        $statement->bindValue(':description', $customer['description'], PDO::PARAM_STR);
        $statement->bindValue(':created_date', $customer['created_date'], PDO::PARAM_STR);
        $statement->bindValue(':id_type', $customer['id_type'], PDO::PARAM_INT);

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
        `email` = :email,`description` = :description, `created_date` = :created_date, `id_type` = :id_type
        WHERE id=:id");
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
        $statement->bindValue(':id_type', $customer['id_type'], PDO::PARAM_INT);

        return $statement->execute();
    }
}
