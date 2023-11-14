<?php

namespace App\Controller;

use App\Model\SearchManager;

class SearchController extends AbstractController
{
    public function indexSearch(): string
    {
        if (isset($_SESSION['user_id']) === true) {
            return $this->twig->render('search/index.html.twig');
        } else {
            header('Location: /');
            die();
        }
    }
}
