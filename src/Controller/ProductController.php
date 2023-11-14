<?php

namespace App\Controller;

use App\Model\ProductManager;

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
}
