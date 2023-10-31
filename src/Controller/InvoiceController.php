<?php

namespace App\Controller;

use App\Model\InvoiceManager;

class InvoiceController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('Customer/index.html.twig');
    }
}
