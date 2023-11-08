<?php

namespace App\Controller;

use App\Model\CategoryManager;

class CategoryController extends AbstractController
{
    public function indexCategory(): string
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAll('name');

        return $this->twig->render('Category/index.html.twig', ['categories' => $categories]);
    }

    public function show(int $id): string
    {
        $categoryManager = new CategoryManager();
        $item = $categoryManager->selectOneById($id);

        return $this->twig->render('Category/index.html.twig', ['item' => $item]);
    }
    public function addCategory(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $category = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, insert and redirection
            $categoryManager = new CategoryManager();
            $category = $categoryManager->addCategory($category);

            header('Location:/categories/');
            return null;
        }
        return $this->twig->render('Category/add.html.twig');
    }
}
