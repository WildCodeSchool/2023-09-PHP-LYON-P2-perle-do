<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    '' => ['AuthController', 'login',],
    'home' => ['HomeController','index',],
    // pages catégories
    'categories' => ['CategoryController','indexCategory',],
    'categories/edit' => ['CategoryController', 'editCategory', ['id']],
    'categories/add' => ['CategoryController', 'addCategory',],
    'categories/delete' => ['CategoryController', 'deleteCategory',],
    // pages matériaux
    'materials' => ['MaterialController','indexMaterial',['categoryId']],
    'materials/edit' => ['MaterialController', 'editMaterial', ['id']],
    'materials/add' => ['MaterialController', 'addMaterial',],
    'materials/delete' => ['MaterialController', 'deleteMaterial',],
    // pages produits
    'products' => ['ProductController','indexProduct',['categoryId', 'materialId']],
    'products/edit' => ['ProductController', 'editProduct', ['id']],
    'products/show' => ['ProductController', 'showProduct', ['id']],
    'products/add' => ['ProductController', 'addProduct',],
    'products/delete' => ['ProductController', 'deleteProduct', ['id']],
    // pages clients
    'customers' => ['CustomerController', 'indexCustomer',],
    'customers/edit' => ['CustomerController', 'editCustomer', ['id']],
    'customers/show' => ['CustomerController', 'showCustomer', ['id']],
    'customers/add' => ['CustomerController', 'addCustomer',],
    'customers/delete' => ['CustomerController', 'deleteCustomer', ['id']],
    // pages factures
    'invoices' => ['InvoiceController', 'indexInvoice',],
    'invoices/edit' => ['InvoiceController', 'editInvoice', ['id']],
    'invoices/show' => ['InvoiceController', 'showInvoice', ['id']],
    'invoices/add' => ['InvoiceController', 'addInvoice',],
    'invoices/delete' => ['InvoiceController', 'deleteInvoice',],
    // pages recherche
    'search' => ['SearchController','indexSearch',],
    // page ajout utilisateur
    'user' => ['UserController','indexUser'],
    'user/add' => ['UserController','register'],
    'user/show' => ['UserController','show', ['id']],
    'user/edit' => ['UserController','edit', ['id']],
    'user/delete' => ['UserController','delete'],

    // page de déconnection
    'logout' => ['AuthController','logout'],


    'items' => ['ItemController', 'index',],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
    'items/delete' => ['ItemController', 'delete',],
];
