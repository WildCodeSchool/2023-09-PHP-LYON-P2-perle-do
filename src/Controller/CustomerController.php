<?php

namespace App\Controller;

use App\Model\CustomerManager;

class CustomerController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('Customer/index.html.twig');
    }
}
