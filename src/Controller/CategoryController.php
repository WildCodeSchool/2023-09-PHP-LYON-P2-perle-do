<?php

namespace App\Controller;

use App\Model\CategoryManager;

class CategoryController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('Category/index.html.twig');
    }
    public function add(): string
    {
        return $this->twig->render('Category/add.html.twig');
    }
}
