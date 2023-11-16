<?php

namespace App\Controller;

use App\Model\ProductManager;

class ShopController extends AbstractController
{
    /**
     * List items
     */
    public function indexShop(): string
    {
        if (isset($_SESSION['user_id'])) {
            $productManager = new ProductManager();
            $cart = $_SESSION['cart'];
            $products = [];
            foreach ($cart as $key) {
                $products[] = $productManager->getProductById($key);
            }

            return $this->twig->render('Shop/index.html.twig', [
                'products' => $products,
            ]);
        } else {
            header('Location: /');
            die();
        }
    }
}
