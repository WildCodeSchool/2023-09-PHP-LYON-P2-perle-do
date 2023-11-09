<?php

namespace App\Controller;

use App\Model\MaterialManager;

class MaterialController extends AbstractController
{
    public function indexMaterial(int $id): string
    {
        $materialManager = new MaterialManager();
        $materials = $materialManager -> getMaterialById($id);

        return $this->twig->render('Material/index.html.twig', ['materials' => $materials]);
    }

    //   public function showMaterial(int $id): string
    // {
    //     $materialManager = new MaterialManager();
    //     $material = $materialManager->getMaterialById($id);
    //     return $this->twig->render('Customer/show.html.twig', [
    //         'material' => $material,
    //     ]);
    // }
}
