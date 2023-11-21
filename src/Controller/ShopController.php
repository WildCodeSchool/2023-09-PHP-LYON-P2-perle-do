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
            if (isset($_SESSION['cart'])) {
                $productManager = new ProductManager();
                $customerManager = new CustomerManager();



                $cart = $_SESSION['cart'];
                $errors = [];
                $products = [];

                foreach ($cart as $productId => $quantity) {
                    $aProductInfo = $productManager->getProductById($productId);
                    $aProductInfo['realQuantity'] = $quantity;
                    if (is_array($aProductInfo)) {
                        $products[] = $aProductInfo;
                    }
                }
                $payment = new PaymentManager();
                $payments = $payment->selectAll();

                $customers = $customerManager->getAllCustomer();



                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // clean $_POST data

                    $cartValid = array_map('trim', $_POST);

                    $errorsValidation = new ValidationCart();
                    $errorsValidation->cartValidation($cartValid);
                    $errors = $errorsValidation->errors;

                    if (empty($errors)) {
                        // if validation is ok, insert and redirection
                        $invoiceManager = new InvoiceManager();
                        $cartValid['discount'] = floatval($cartValid['discount']);


                        $invoiceId = $invoiceManager->addInvoice($cartValid);

                        // foreach $product in $cartValid,
                        foreach ($cart as $productId => $quantity) {
                            $invoiceManager->addInvoiceProduct($productId, $quantity, $invoiceId);
                        }

                        unset($_SESSION['cart']);
                        header('Location: /shop');
                        exit;
                    } else {
                        return $this->twig->render(
                            'Shop/index.html.twig',
                            [
                                'errors' => $errors,
                                'products' => $products,
                                'customers' => $customers,
                                'payments' => $payments,
                            ]
                        );
                    }
                } else {
                    return $this->twig->render(
                        'Shop/index.html.twig',
                        [
                            'products' => $products,
                            'customers' => $customers,
                            'payments' => $payments,
                        ]
                    );
                }
            } else {
                return $this->twig->render('Shop/index.html.twig');
            }
        } else {
            header('Location: /');
            die();
        }
    }
}
