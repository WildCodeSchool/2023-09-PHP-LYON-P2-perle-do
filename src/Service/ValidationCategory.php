<?php

namespace App\Service;

class ValidationCategory
{
    public array $errors;
    public function __construct()
    {
        $this->errors = [];
    }

    public function formValidationCategory(array $category): void
    {
        if (empty($category['name'])) {
            $this->errors[] = "Le nom est obligatoire";
        }
        if (strlen($category['name']) > 50) {
            $this->errors[] = "Le nom est trop long";
        }
    }
}
