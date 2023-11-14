<?php

namespace App\Controller;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        if (isset($_SESSION['user_id']) === true) {
            return $this->twig->render('Home/index.html.twig');
        } else {
            header('Location: /');
            die();
        }
    }
}
