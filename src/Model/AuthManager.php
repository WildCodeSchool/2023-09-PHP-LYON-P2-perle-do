<?php

namespace App\Model;

use PDO;

class AuthManager extends AbstractManager
{
    public const TABLE = 'user';

    public function selectOneByLogin(string $pseudo): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE pseudo=:pseudo");
        $statement->bindValue('pseudo', $pseudo, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }
}
