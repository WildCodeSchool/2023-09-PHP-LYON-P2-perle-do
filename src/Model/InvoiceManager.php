<?php

namespace App\Model;

use PDO;

class InvoiceManager extends AbstractManager
{
    public function getOneInvoiceById(int $id): array|false
    {
        $sql = "SELECT i.id, i.num_invoice numInvoice, i.date, i.total, i.discount, 
        i.payment_type, p.name productName, p.price, p.reference productReference,
        c.lastname, c.firstname, c.reference customerReference, c.adress, c.zipcode, 
        c.city, t.discount customerDiscount
        FROM invoice i
        JOIN product_invoice pi ON i.id = pi.id_invoice
        JOIN product p ON p.id = pi.id_product
        JOIN customer c ON c.id = i.id_customer
        JOIN type t ON t.id = c.id_type
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
}
