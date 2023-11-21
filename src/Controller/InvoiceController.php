<?php

namespace App\Controller;

use App\Model\InvoiceManager;
use App\Model\ProductManager;
use App\mikehaertl\wkhtmlto\Pdf;

class InvoiceController extends AbstractController
{
    public function showInvoice($id): string
    {
        if (isset($_SESSION['user_id'])) {
            $invoiceManager = new InvoiceManager();
            $invoice = $invoiceManager->getOneInvoiceById($id);

            $productManager = new ProductManager();
            $products = $productManager->getProductsbyInvoice($id);

            return $this->twig->render('Invoice/show.html.twig', [
                'invoice' => $invoice,
                'products' => $products,
            ]);
        } else {
            header('Location: /');
            die();
        }
    }

    public function indexInvoice(): string
    {
        if (isset($_SESSION['user_id'])) {
            $invoiceManager = new InvoiceManager();
            $invoices = $invoiceManager->getAllInvoices();

            return $this->twig->render('Invoice/index.html.twig', [
                'invoices' => $invoices,
            ]);
        } else {
            header('Location: /');
            die();
        }
    }
}
