<?php

namespace App\Controller;

use App\Model\CategoryManager;

class CategoryController extends AbstractController
{
    // public function index(): string
    // {
    //     return $this->twig->render('Category/index.html.twig');
    // }

    public function index(): string
    {
        $categoryManager = new CategoryManager();
        $category = $categoryManager->selectAll('title');

        return $this->twig->render('Category/index.html.twig', ['category' => $category]);
    }
}
