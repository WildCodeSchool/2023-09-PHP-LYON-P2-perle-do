<?php

namespace App\Service;

class ValidationMaterial
{
    public array $errors;
    public function __construct()
    {
        $this->errors = [];
    }

    public function formValidationMaterial(array $category): void
    {
        if (empty($category['name'])) {
            $this->errors[] = "Le nom est obligatoire";
        }
        if (strlen($category['name']) > 50) {
            $this->errors[] = "Le nom est trop long";
        }
    }
}
