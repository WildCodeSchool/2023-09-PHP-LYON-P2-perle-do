<?php

namespace App\Controller;

use App\Model\MaterialManager;
use App\Service\ValidationMaterial;

class MaterialController extends AbstractController
{
    public function indexMaterial(int $categoryId): string
    {
        $materialManager = new MaterialManager();
        $materials = $materialManager->getAllMaterial($categoryId);

        if (isset($_SESSION['user_id']) === true) {
            return $this->twig->render('Material/index.html.twig', [
                'materials' => $materials,
                'category' => $categoryId,
            ]);
        } else {
            header('Location: /');
            die();
        }
    }
    public function addMaterial(): ?string
    {
        if (isset($_SESSION['user_id']) === true) {
            $errors = [];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $material = array_map('trim', $_POST);

                $errorsValidation = new ValidationMaterial();
                $errorsValidation->formValidationMaterial($material);
                $errors = $errorsValidation->errors;

                if (empty($errors)) {
                    $materialManager = new MaterialManager();
                    $material = $materialManager->addMaterial($material);

                    header('Location:/materials/add');
                    return null;
                }
            }
            return $this->twig->render('material/add.html.twig', ['errors' => $errors,]);
        } else {
            header('Location: /');
            die();
        }
    }
    public function editMaterial(int $id): ?string
    {
        $errors = [];
        $materialManager = new MaterialManager();
        $material = $materialManager->selectOneById($id);


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $updatedMaterial = array_map('trim', $_POST);
            // TODO validations (length, format...)
            $errorsValidation = new ValidationMaterial();
            $errorsValidation->formValidationMaterial($material);
            $errors = $errorsValidation->errors;

            if (empty($errors)) {
            // if validation is ok, update and redirection
                $materialManager->updateMaterial($updatedMaterial);

                header('Location: /materials');

            // we are redirecting so we don't want any content rendered
                return null;
            }
        }
        return $this->twig->render('material/edit.html.twig', [
            'material' => $material,
            'errors' => $errors
        ]);
    }
}
