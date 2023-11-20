<?php

namespace App\Controller;

use App\Model\CustomerManager;
use App\Model\InvoiceManager;
use App\Model\PaymentManager;
use App\Model\ProductManager;
use App\Service\ValidationCart;

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
            $errors = [];
            $products = [];

            foreach ($cart as $productId => $quantity) {
                $quantity = $quantity;
                $aProductInfo = $productManager->getProductById($productId);
                if (is_array($aProductInfo)) {
                    $products[] = $aProductInfo;
                }
            }
            $payment = new PaymentManager();
            $payments = $payment->selectAll();

            $customers = $customerManager->getAllCustomer();



            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // clean $_POST data

                $cart_valid = array_map('trim', $_POST);
 //var_dump($cart_valid);
  //              die();
                $errorsValidation = new ValidationCart();
                $errorsValidation->cartValidation($cart_valid);
                $errors = $errorsValidation->errors;
               
                if (empty($errors)) {
                    // if validation is ok, insert and redirection
                    $invoiceManager = new InvoiceManager();
                    $invoiceManager->addInvoice($cart_valid);

                    return $this->twig->render('Shop/index.html.twig',
                    [
                        'products' => $products,
                        'customers' => $customers,
                        'payments' => $payments,
                    ]);
                } else {
                    return $this->twig->render('Shop/index.html.twig',
                    [
                        'errors' => $errors,
                        'products' => $products,
                        'customers' => $customers,
                        'payments' => $payments,
                    ]);
                }
            } else {
                return $this->twig->render('Shop/index.html.twig',
                    [
                        'products' => $products,
                        'customers' => $customers,
                        'payments' => $payments,
                    ]);
            }
        } else {
            header('Location: /');
            die();
        }
    }
}
