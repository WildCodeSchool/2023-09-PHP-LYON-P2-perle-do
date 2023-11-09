<?php

namespace App\Service;

class ValidationService
{
    public array $errors;
    public function __construct()
    {
        $this->errors = [];
    }

    public function formValidationCustomer($customer): void
    {
        if (empty($customer['lastname'])) {
            $this->errors[] = "Le nom est obligatoire";
        }
        if (strlen($customer['lastname']) > 50) {
            $this->errors[] = "Le nom est trop long";
        }
        if (empty($customer['firstname'])) {
            $this->errors[] = "Le prénom est obligatoire";
        }
        if (strlen($customer['firstname']) > 50) {
            $this->errors[] = "Le prénom est trop long";
        }
        if (strlen($customer['adress']) > 100) {
            $this->errors[] = "L\'adresse est trop longue, raccourci-la";
        }
    }

    public function formValidationCustomer2($customer): void
    {
        if (strlen($customer['city']) > 50) {
            $this->errors[] = "Le nom de la ville est trop long";
        }
        if (!empty($customer['zipcode']) && !preg_match('/[0-9]{5}/', $customer['zipcode'])) {
            $this->errors[] = "Le CP n\'est pas au bon format";
        }
        if (!empty($customer['email']) && !filter_var($customer['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "L'adresse mail n'est pas au bon format";
        }
    }

    public function formValidationCustomer3($customer): void
    {
        if (!empty($customer['phone']) && !preg_match('/[0-9]{10}/', $customer['phone'])) {
            $this->errors[] = "Le numéro de téléphone n\'est pas au bon format";
        }
        if ($customer['civility'] != "Monsieur" && $customer['civility'] != "Madame") {
            $this->errors[] = "Civilité non conforme";
        }
    }
}
