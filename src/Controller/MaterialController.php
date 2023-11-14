<?php

namespace App\Controller;

use App\Model\MaterialManager;

class MaterialController extends AbstractController
{
    public function indexMaterial(int $categoryId): string
    {
        $materialManager = new MaterialManager();
        $materials = $materialManager -> getAllMaterial($categoryId);

        if (isset($_SESSION['user_id']) === true) {
            return $this->twig->render('Material/index.html.twig', [
            'materials' => $materials,
            'category' => $categoryId,]);
        } else {
            header('Location: /');
            die();
        }
    }
}
