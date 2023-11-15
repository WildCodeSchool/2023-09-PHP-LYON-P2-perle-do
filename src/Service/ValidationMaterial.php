<?php

namespace App\Service;

class ValidationMaterial
{
    public array $errors;
    public function __construct()
    {
        $this->errors = [];
    }

    public function formValidationMaterial(array $material): void
    {
        if (empty($material['name'])) {
            $this->errors[] = "Le nom est obligatoire";
        }
    }
}
