<?php

namespace App\Controller;

use App\Model\CustomerManager;
use App\Model\TypeManager;

class CustomerController extends AbstractController
{
    public function indexCustomer(): string
    {
        $customerManager = new CustomerManager();
        $customers = $customerManager->getAll();

        return $this->twig->render('Customer/index.html.twig', ['customers' => $customers]);
    }

    public function addCustomer(): ?string
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $customer = array_map('trim', $_POST);
            $customer['created_date'] = date("Y-m-d");

            // TODO validations (length, format...)
            if (empty($customer['lastname'])) {
                $errors[] = 'Le nom est obligatoire';
            }
            if (strlen($customer['lastname']) > 50) {
                $errors[] = 'Le nom ou le prénom est trop long';
            }
            if (!empty($customer['email'])) {
                if (!filter_var($customer['email'], FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "L'adresse mail n'est pas au bon format";
                }
            }
            if (!empty($customer['phone'])) {
                if (!preg_match('/[0-9]{10}/', $customer['phone'])) {
                    $errors[] = 'Le numéro n\'est pas au bon format';
                }
            }

            if (empty($errors)) {
                // if validation is ok, insert and redirection
                $customerManager = new CustomerManager();
                $id = $customerManager->insert($customer);

                header('Location:/customers/show?id=' . $id);
                return null;
            }
        }
        $typeManager = new TypeManager();
        $types = $typeManager->selectAll();
        return $this->twig->render('customer/add.html.twig', [
            'types' => $types,
            'errors' => $errors
        ]);
    }
}
