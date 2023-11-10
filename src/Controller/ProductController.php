<?php

namespace App\Controller;

use App\Model\ProductManager;

class ProductController extends AbstractController
{
    public function indexProduct($categoryId, $materialId): string
    {
        $productManager = new ProductManager();
        $products = $productManager -> getProductByCategoryAndMaterial($categoryId, $materialId);

        return $this->twig->render('Product/index.html.twig', ['products' => $products]);
    }
}
