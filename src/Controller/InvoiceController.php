<?php

namespace App\Controller;

use App\Model\InvoiceManager;

class InvoiceController extends AbstractController
{
    public function index(): string
    {
        if (isset($_SESSION['user_id'])) {
            return $this->twig->render('Customer/index.html.twig');
        } else {
            header('Location: /');
            die();
        }
    }
}
