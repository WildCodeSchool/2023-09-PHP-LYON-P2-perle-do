<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    '' => ['AuthController', 'index',],
    'home' => ['HomeController','index',],
    // pages catégories
    'categories' => ['CategoryController','index',],
    'categories/edit' => ['CategoryController', 'edit', ['id']],
    'categories/add' => ['CategoryController', 'add',],
    'categories/delete' => ['CategoryController', 'delete',],
    // pages matériaux
    'materials' => ['MaterialController','index',],
    'materials/edit' => ['MaterialController', 'edit', ['id']],
    'materials/add' => ['MaterialController', 'add',],
    'materials/delete' => ['MaterialController', 'delete',],
    // pages produits
    'products' => ['ProductController','index',],
    'products/edit' => ['ProductController', 'edit', ['id']],
    'products/show' => ['ProductController', 'show', ['id']],
    'products/add' => ['ProductController', 'add',],
    'products/delete' => ['ProductController', 'delete',],
    // pages clients
    'customers' => ['CustomerController', 'index',],
    'customers/edit' => ['CustomerController', 'edit', ['id']],
    'customers/show' => ['CustomerController', 'show', ['id']],
    'customers/add' => ['CustomerController', 'add',],
    'customers/delete' => ['CustomerController', 'delete',],
    // pages factures
    'invoices' => ['InvoiceController', 'index',],
    'invoices/edit' => ['InvoiceController', 'edit', ['id']],
    'invoices/show' => ['InvoiceController', 'show', ['id']],
    'invoices/add' => ['InvoiceController', 'add',],
    'invoices/delete' => ['InvoiceController', 'delete',],
    // pages recherche
    'search' => ['SearchController','index',],


    'items' => ['ItemController', 'index',],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
    'items/delete' => ['ItemController', 'delete',],
];
