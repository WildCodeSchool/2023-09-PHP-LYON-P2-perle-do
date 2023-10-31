<?php

namespace App\Controller;

use App\Model\ProductManager;

class ProductController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('Product/index.html.twig');
    }
}
