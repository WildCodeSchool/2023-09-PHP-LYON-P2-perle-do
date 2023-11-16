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

        if (isset($_SESSION['user_id'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $_SESSION['cart'][$_POST['product_id']] = $_POST['quantity'];
            }

            $productManager = new ProductManager();
            $products = $productManager->getProductsByCategoryAndMaterial($category, $material);
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
            $categorys = $categoryManager->selectAll('name');
            $materialManager = new MaterialManager();
            $materials = $materialManager->selectAll('name');
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

    public function showProduct(int $id): string
    {
        if (isset($_SESSION['user_id'])) {
            $productManager = new ProductManager();
            $product = $productManager->getProductById($id);
            $categoryManager = new CategoryManager();
            $category = $categoryManager->selectOneById($id);
            $materialManager = new MaterialManager();
            $material = $materialManager->selectOneById($id);

            return $this->twig->render('product/show.html.twig', [
                'product' => $product,
                'category' => $category,
                'material' => $material,
            ]);
        } else {
            header('Location: /');
            die();
        }
    }

    public function deleteProduct(int $id): void
    {
        if (isset($_SESSION['user_id'])) {
                $productManager = new ProductManager();
                $product = $productManager->selectOneById($id);
                $productManager->delete((int)$id);
                header('Location:/products?categoryId=' . $product['id_category'] .
                '&materialId=' . $product['id_material']);
        } else {
            header('Location: /');
            die();
        }
    }
    public function editProduct(int $id): ?string
    {
        if (isset($_SESSION['user_id'])) {
            $errors = [];
            $productManager = new ProductManager();
            $product = $productManager->getProductById($id);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // clean $_POST data
                $updatedProduct = array_map('trim', $_POST);
                // TODO validations (length, format...)
                $errorsValidation = new ValidationProduct();
                $errorsValidation->formValidationProduct($updatedProduct);
                $errorsValidation->formValidationProduct2($updatedProduct);
                $errors = $errorsValidation->errors;

                if (empty($errors)) {
                    // if validation is ok, update and redirection
                    $productManager->update($updatedProduct);

                    header('Location: /products/show?id=' . $id);

                    // we are redirecting so we don't want any content rendered
                    return null;
                }
            }
            $categoryManager = new CategoryManager();
            $categories = $categoryManager->selectAll('name');
            $materialManager = new MaterialManager();
            $materials = $materialManager->selectAll('name');

            return $this->twig->render('product/edit.html.twig', [
                'product' => $product,
                'categorys' => $categories,
                'materials' => $materials,
                'errors' => $errors
            ]);
        } else {
            header('Location: /');
            die();
        }
    }
}
