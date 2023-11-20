<?php

namespace App\Model;

use PDO;

class InvoiceManager extends AbstractManager
{
    public const TABLE = 'invoice';
    public function addInvoice($invoice)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`num_invoice`, `date`,`total`,`discount`,`payment_type_id`,`id_customer`) 
        VALUES (:num_invoice, :date, :total, :discount, :payment_type_id, :id_customer)");
        $statement->bindValue('num_invoice', 'toto', PDO::PARAM_STR);
        $statement->bindValue('date', date("Y-m-d"), PDO::PARAM_STR);
        $statement->bindValue('total', $invoice['total'], PDO::PARAM_INT);
        $statement->bindValue('discount', $invoice['discount'], PDO::PARAM_INT);
        $statement->bindValue('payment_type_id', $invoice['payment'], PDO::PARAM_INT);
        $statement->bindValue('id_customer', $invoice['customers'], PDO::PARAM_INT);
 
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
