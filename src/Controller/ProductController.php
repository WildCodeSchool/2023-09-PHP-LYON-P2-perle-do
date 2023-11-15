<?php

namespace App\Controller;

use App\Model\CategoryManager;
use App\Model\MaterialManager;
use App\Model\ProductManager;
use App\Service\ValidationProduct;

class ProductController extends AbstractController
{
    public function indexProduct(int $category, int $material): string
    {
        $productManager = new ProductManager();
        $products = $productManager->getProductsByCategoryAndMaterial($category, $material);
        if (isset($_SESSION['user_id'])) {
            return $this->twig->render('Product/index.html.twig', [
                'products' => $products,
                'category' => $category,
                'material' => $material,
            ]);
        } else {
            header('Location: /');
            die();
        }
    }

    public function addProduct(): ?string
    {
        if (isset($_SESSION['user_id'])) {
            $errors = [];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // clean $_POST data
                $product = array_map('trim', $_POST);

                $errorsValidation = new ValidationProduct();
                $errorsValidation->formValidationProduct($product);
                $errorsValidation->formValidationProduct2($product);
                $errors = $errorsValidation->errors;

                if (empty($errors)) {
                    // if validation is ok, insert and redirection
                    $productManager = new ProductManager();
                    $id = $productManager->insertProduct($product);

                    header('Location:/products/show?id=' . $id);
                    return null;
                }
            }
            $categoryManager = new CategoryManager();
            $categorys = $categoryManager->selectAll();
            $materialManager = new MaterialManager();
            $materials = $materialManager->selectAll();
            return $this->twig->render('product/add.html.twig', [
                'categorys' => $categorys,
                'materials' => $materials,
                'errors' => $errors
            ]);
        } else {
            header('Location: /');
            die();
        }
    }
}
