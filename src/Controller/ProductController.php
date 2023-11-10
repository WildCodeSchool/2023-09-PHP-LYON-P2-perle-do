<?php

namespace App\Controller;

use App\Model\ProductManager;

class ProductController extends AbstractController
{
    public function index(): string
    {
        if (isset($_SESSION['user_id']) === true) {
            return $this->twig->render('Product/index.html.twig');
        } else {
            header('Location: /');
            die();
        }
    }
}
