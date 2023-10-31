<?php

namespace App\Controller;

use App\Model\AuthManager;

class AuthController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('Auth/index.html.twig');
    }
}
