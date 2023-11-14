<?php

namespace App\Service;

class ValidationProduct
{
    public array $errors;
    public function __construct()
    {
        $this->errors = [];
    }

    public function formValidationProduct(array $product): void
    {
        if (empty($product['name'])) {
            $this->errors[] = "Le nom du produit est obligatoire";
        }
        if (strlen($product['name']) > 50) {
            $this->errors[] = "Le nom du produit est trop long";
        }
    }


    public function formValidationProduct2(array $product): void
    {
        if (empty($product['reference'])) {
            $this->errors[] = "La référence du produit est obligatoire";
        }
        if (strlen($product['reference']) > 10) {
            $this->errors[] = "La référence est trop longue";
        }
        if (empty($product['price'])) {
            $this->errors[] = "Le prix est obligatoire";
        }
        if (strlen($product['description']) > 255) {
            $this->errors[] = "La description est trop longue";
        }
        if (strlen($product['origin']) > 100) {
            $this->errors[] = "L\'indication de l'origine est trop longue";
        }
    }
}
