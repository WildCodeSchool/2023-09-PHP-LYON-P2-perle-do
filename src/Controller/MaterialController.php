<?php

namespace App\Controller;

use App\Model\MaterialManager;

class MaterialController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('Material/index.html.twig');
    }
}
