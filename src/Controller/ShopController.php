<?php

namespace App\Controller;

use App\Model\CustomerManager;
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
            $customerManager = new CustomerManager();

            $cart = $_SESSION['cart'];

            $products = [];

            foreach ($cart as $productId => $quantity) {
                $quantity = $quantity;
                $aProductInfo = $productManager->getProductById($productId);
                if (is_array($aProductInfo)) {
                    $products[] = $aProductInfo;
                }
            }

            $customers = $customerManager->getAllCustomer();

            return $this->twig->render('Shop/index.html.twig', [
                'products' => $products,
                'customers' => $customers,
            ]);
        } else {
            header('Location: /');
            die();
        }
    }
}
