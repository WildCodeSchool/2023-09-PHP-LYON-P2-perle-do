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

            $errors = [];
            // TODO validations (length, format...)
            if (empty($category['name'])) {
                $errors[] = "Le nom est obligatoire";
            }
            if (strlen($category['name']) > 5) {
                $errors[] = "Le nom est trop long";
            }
            // if validation is ok, insert and redirection
            $categoryManager = new CategoryManager();
            $category = $categoryManager->addCategory($category);

            header('Location:/categories/');
            return null;
        }
        return $this->twig->render('Category/add.html.twig');
    }

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $categoryManager = new CategoryManager();
            $categoryManager->delete((int)$id);

            header('Location:/Category/index.html.twig.php');
        }
    }
}
