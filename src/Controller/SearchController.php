<?php

namespace App\Controller;

use App\Model\SearchManager;

class SearchController extends AbstractController
{
    public function indexSearch(): string
    {
        return $this->twig->render('search/index.html.twig');
    }
}
