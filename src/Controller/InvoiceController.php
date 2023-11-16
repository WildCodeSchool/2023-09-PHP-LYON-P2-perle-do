<?php

namespace App\Controller;

use App\Model\InvoiceManager;
use Pdf;

class InvoiceController extends AbstractController
{
    public function indexInvoice(): string
    {
        if (isset($_SESSION['user_id'])) {
            return $this->twig->render('Invoice/index.html.twig');
        } else {
            header('Location: /');
            die();
        }
    }

    // public function showInvoice($id): void
    // {
    //     if (isset($_SESSION['user_id'])) {
    //         $invoiceManager = new InvoiceManager();
    //         // $invoice = $invoiceManager->selectOneById($id);
    //         // $PDF = new \mikehaertl\wkhtmlto\Pdf($invoice);
    //         // $PDF->send();
    //     } else {
    //         header('Location: /');
    //         die();
    //     }
    // }
}
