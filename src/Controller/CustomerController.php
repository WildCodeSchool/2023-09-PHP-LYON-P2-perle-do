<?php

namespace App\Controller;

use App\Model\CustomerManager;
use App\Model\TypeManager;
use App\Service\ValidationService;

class CustomerController extends AbstractController
{
    public function indexCustomer(): string
    {
        if (isset($_SESSION['user_id']) === true) {
            $customerManager = new CustomerManager();
            $customers = $customerManager->getAllCustomer();

            return $this->twig->render('Customer/index.html.twig', ['customers' => $customers]);
        } else {
            header('Location: /');
            die();
        }
    }

    public function addCustomer(): ?string
    {
        if (isset($_SESSION['user_id']) === true) {
            $errors = [];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // clean $_POST data
                $customer = array_map('trim', $_POST);
                $customer['created_date'] = date("Y-m-d");


                $errorsValidation = new ValidationService();
                $errorsValidation->formValidationCustomer($customer);
                $errorsValidation->formValidationCustomer2($customer);
                $errorsValidation->formValidationCustomer3($customer);
                $errors = $errorsValidation->errors;

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
        } else {
            header('Location: /');
            die();
        }
    }

    public function showCustomer(int $id): string
    {
        if (isset($_SESSION['user_id']) === true) {
            $customerManager = new CustomerManager();
            $customer = $customerManager->getCustomerById($id);
            $typeManager = new TypeManager();
            $type = $typeManager->getTypeById($id);

            return $this->twig->render('customer/show.html.twig', [
                'customer' => $customer,
                'type' => $type,
            ]);
        } else {
            header('Location: /');
            die();
        }
    }

    public function deleteCustomer($id): void
    {
        if (isset($_SESSION['user_id']) === true) {
            $costumerManager = new CustomerManager();
            $costumerManager->delete((int)$id);

            header('Location:/customers');
        } else {
            header('Location: /');
            die();
        }
    }

    public function editCustomer(int $id): ?string
    {
        if (isset($_SESSION['user_id']) === true) {
            $errors = [];
            $customerManager = new CustomerManager();
            $customer = $customerManager->getCustomerById($id);


            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // clean $_POST data
                $updatedCustomer = array_map('trim', $_POST);
                // TODO validations (length, format...)
                $errorsValidation = new ValidationService();
                $errorsValidation->formValidationCustomer($updatedCustomer);
                $errorsValidation->formValidationCustomer2($updatedCustomer);
                $errorsValidation->formValidationCustomer3($updatedCustomer);
                $errors = $errorsValidation->errors;

                if (empty($errors)) {
                    // if validation is ok, update and redirection
                    $customerManager->update($updatedCustomer);

                    header('Location: /customers/show?id=' . $id);

                    // we are redirecting so we don't want any content rendered
                    return null;
                }
            }
            $typeManager = new TypeManager();
            $types = $typeManager->selectAll();
            return $this->twig->render('customer/edit.html.twig', [
                'customer' => $customer,
                'types' => $types,
                'errors' => $errors
            ]);
        } else {
            header('Location: /');
            die();
        }
    }
}
