<?php

namespace App\Controller;

use App\Model\SearchManager;

class SearchController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('search/index.html.twig');
    }
}
