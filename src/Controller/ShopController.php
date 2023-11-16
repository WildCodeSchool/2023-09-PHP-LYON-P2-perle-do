<?php

namespace App\Controller;

class ShopController extends AbstractController
{
    /**
     * List items
     */
    public function index(): string
    {
        return $this->twig->render('Shop/index.html.twig');
    }
}
