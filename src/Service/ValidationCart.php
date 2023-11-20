<?php

namespace App\Service;

class ValidationCart
{
    public array $errors;
    public function __construct()
    {
        $this->errors = [];
    }

    public function cartValidation(array $cart): void
    {
        if (empty($cart['payment'])) {
            $this->errors[] = "La méthode de payment est obligatoire";
        }
        if (empty($cart['customers'])) {
            $this->errors[] = "Le client est obligatoire";
        }
    }
}
