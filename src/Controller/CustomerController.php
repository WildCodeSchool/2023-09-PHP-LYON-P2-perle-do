<?php

namespace App\Controller;

use App\Model\CustomerManager;

class CustomerController extends AbstractController
{
    public function indexCustomer(): string
    {
        return $this->twig->render('Customer/index.html.twig');
    }

    // public function addCustomer(): string
    // {
    //     $errors = [];

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         // clean $_POST data
    //         $customer = array_map('trim', $_POST);


    //         // TODO validations (length, format...)
    //         $errors = $this->validate($customer);
    //         // if validation is ok, insert and redirection
    //         $CustomerManager = new CustomerManager();
    //         $id = $CustomerManager->insert($customer);


    //         header('Location:/customers/show?id=' . $id);
    //         return null;
    //     }
    //     return $this->twig->render('customer/add.html.twig');
    // }
    // private function validate(array $customer)
    // {
    //     if (empty($customer['lastname'])) {
    //         $errors[] = 'Le nom est obligatoire';
    //     }
    //     if (empty($customer['firstname'])) {
    //         $errors[] = 'Le prénom est obligatoire';
    //     }
    //     if (empty($customer['reference'])) {
    //         $errors[] = 'La référence client est obligatoire';
    //     }

    //     return $errors ?? [];
    // }
}
