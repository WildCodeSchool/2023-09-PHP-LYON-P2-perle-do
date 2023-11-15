<?php

namespace App\Service;

class UserService
{
    public array $errors;
    public function __construct()
    {
        $this->errors = [];
    }

    public function userValidation(array $user): void
    {
        if (empty($user['lastname'])) {
            $this->errors[] = "Le nom est obligatoire";
        }
        if (strlen($user['lastname']) > 100) {
            $this->errors[] = "Le nom est trop long";
        }
        if (empty($user['pseudo'])) {
            $this->errors[] = "Le pseudo est obligatoire";
        }
        if (strlen($user['pseudo']) > 20) {
            $this->errors[] = "Le pseudo est trop long";
        }
    }

    public function userValidationExtra(array $user): void
    {
        if (empty($user['name'])) {
            $this->errors[] = "Le prénom est obligatoire";
        }
        if (strlen($user['name']) > 100) {
            $this->errors[] = "Le prénom est trop long";
        }
    }
}
