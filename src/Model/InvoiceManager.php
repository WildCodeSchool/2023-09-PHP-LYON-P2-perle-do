<?php

namespace App\Model;

use PDO;

class InvoiceManager extends AbstractManager
{
    public const TABLE = 'invoice';
    public function getOneInvoiceById(int $id): array|false
    {
        $sql = "SELECT i.id, i.num_invoice numInvoice, i.date, i.total, i.discount,
        c.lastname, c.firstname, c.reference customerReference, c.adress, c.zipcode, 
        c.city, t.discount customerDiscount, pa.name paymentName
        FROM invoice i
        JOIN product_invoice pi ON i.id = pi.id_invoice
        JOIN product p ON p.id = pi.id_product
        JOIN customer c ON c.id = i.id_customer
        JOIN `type` t ON t.id = c.id_type
        JOIN payment_type pa ON i.payment_type_id = pa.id
                WHERE i.id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAllInvoices(): array|bool
    {
        $sql = 'SELECT i.id, i.num_invoice, i.date, i.total, c.lastname, c.firstname
        FROM invoice i
        JOIN customer c ON c.id = i.id_customer';
        $query = $this->pdo->prepare($sql);
        $query->execute();
        $allInvoices = $query->fetchAll(PDO::FETCH_ASSOC);
        return $allInvoices;
    }

    public function getAllInvoicesByCustomer($customerId): array|bool
    {
        $sql = 'SELECT i.id invoiceId, i.num_invoice, i.date, i.total,c.id, c.lastname, c.firstname
        FROM invoice i
        JOIN customer c ON c.id = i.id_customer
        WHERE c.id=:id';
        $query = $this->pdo->prepare($sql);
        $query->bindValue('id', $customerId, PDO::PARAM_INT);
        $query->execute();
        $allInvoices = $query->fetchAll(PDO::FETCH_ASSOC);
        return $allInvoices;
    }
    public function addInvoice($invoice)
    {
        $lastInvoiceNumber = $this->getLastInvoiceNumber();

// Incrémenter le numéro de facture
        $newInvoiceNumber = $lastInvoiceNumber + 1;

        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`num_invoice`, `date`,`total`,`discount`,
        `payment_type_id`,`id_customer`) 
        VALUES (:num_invoice, :date, :total, :discount, :payment_type_id, :id_customer)");
        $statement->bindValue('num_invoice', $newInvoiceNumber, PDO::PARAM_STR);
        $statement->bindValue('date', date("Y-m-d"), PDO::PARAM_STR);
        $statement->bindValue('total', $invoice['total'], PDO::PARAM_INT);
        $statement->bindValue('discount', $invoice['discount']);
        $statement->bindValue('payment_type_id', $invoice['payment'], PDO::PARAM_INT);
        $statement->bindValue('id_customer', $invoice['customers'], PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    private function getLastInvoiceNumber()
    {
        $query = "SELECT MAX(`num_invoice`) AS last_invoice_number FROM " . self::TABLE;
        $result = $this->pdo->query($query)->fetch(PDO::FETCH_ASSOC);
        return $result['last_invoice_number'] ?? 1;
    }

    public function addInvoiceProduct($productId, $quantity, $invoiceId)
    {
        $statement = $this->pdo->prepare("INSERT INTO `product_invoice`(`quantity`, `id_product`, `id_invoice`) 
        VALUES (:quantity, :id_product, :id_invoice)");
        $statement->bindValue('quantity', $quantity, PDO::PARAM_INT);
        $statement->bindValue('id_product', $productId, PDO::PARAM_INT);
        $statement->bindValue('id_invoice', $invoiceId, PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
