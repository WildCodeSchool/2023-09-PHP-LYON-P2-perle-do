<?php

namespace App\Controller;

use App\Model\MaterialManager;

class MaterialController extends AbstractController
{
    public function index(): string
    {
        if (isset($_SESSION['user_id']) === true) {
            return $this->twig->render('Material/index.html.twig');
        } else {
            header('Location: /');
            die();
        }
    }
}
