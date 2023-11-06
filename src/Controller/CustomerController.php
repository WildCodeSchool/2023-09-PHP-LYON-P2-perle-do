<?php

namespace App\Controller;

use App\Model\CustomerManager;

class CustomerController extends AbstractController
{
    public function indexCustomer(): string
    {
        return $this->twig->render('Customer/index.html.twig');
    }

    public function addCustomer(): string
    {
        return $this->twig->render('Customer/add.html.twig');
    }
}
