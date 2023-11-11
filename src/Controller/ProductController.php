<?php

namespace App\Controller;

use App\Model\ProductManager;

class ProductController extends AbstractController
{
    public function indexProduct(int $categoryId, int $materialId): string
    {
        $productManager = new ProductManager();
        $products = $productManager -> getProductByCategoryAndMaterial($categoryId, $materialId);

        return $this->twig->render('Product/index.html.twig', [
            'products' => $products,
            'categoryId' => $categoryId,
            'materialId' => $materialId
        ]);
    }
}
