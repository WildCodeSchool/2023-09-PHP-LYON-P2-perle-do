<?php

namespace App\Controller;

use App\Model\CategoryManager;

class CategoryController extends AbstractController
{
    // public function index(): string
    // {
    //     return $this->twig->render('Category/index.html.twig');
    // }

    public function indexCategory(): string
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAll('name');

        return $this->twig->render('Category/index.html.twig', ['categories' => $categories]);
    }
    public function addCategory(): string
    {
        return $this->twig->render('Category/add.html.twig');
    }
}
