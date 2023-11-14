<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Service\ValidationService;
use App\Service\UserService;

class UserController extends AbstractController
{
    public function show(int $id): string
    {
        if (isset($_SESSION['user_id'])) {
            $userManager = new UserManager();
            $user = $userManager->selectOneById($id);

            return $this->twig->render('User/show.html.twig', ['user' => $user]);
        } else {
            header('Location: /');
            die();
        }
    }

    public function indexUser(): string
    {
        if (isset($_SESSION['user_id'])) {
            $userManager = new UserManager();
            $users = $userManager->selectAll('id');

            return $this->twig->render('User/index.html.twig', ['users' => $users]);
        } else {
            header('Location: /');
            die();
        }
    }

    public function edit(int $id): ?string
    {
        if (isset($_SESSION['user_id'])) {
            $errors = [];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // clean $_POST data
                $user = array_map('trim', $_POST);


                $errorsValidation = new UserService();
                $errorsValidation->userValidation($user);
                $errorsValidation->userValidationExtra($user);
                $errors = $errorsValidation->errors;

                if (empty($errors)) {
                    // if validation is ok, insert and redirection
                    $userManager = new UserManager();
                    $id = $userManager->update($user);

                    header('Location:/user/show?id=' . $id);
                    return null;
                } else {
                    return $this->twig->render('User/edit.html.twig', [
                        'errors' => $errors
                    ]);
                }
            }

            return $this->twig->render('User/edit.html.twig');
        } else {
            header('Location: /');
            die();
        }
    }

    public function delete(): void
    {
        if (isset($_SESSION['user_id'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = trim($_POST['id']);
                $userManager = new UserManager();
                $userManager->delete((int)$id);

                header('Location:/user');
            }
        } else {
            header('Location: /');
            die();
        }
    }

    public function register()
    {
        if (isset($_SESSION['user_id'])) {
            $errors = [];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // clean $_POST data
                $user = array_map('trim', $_POST);
                $errorsValidation = new ValidationService();
                $errorsValidation->userValidation($user);
                $errorsValidation->userValidationExtra($user);
                $errors = $errorsValidation->errors;

                if (empty($errors)) {
                    // if validation is ok, insert and redirection
                    $userManager = new UserManager();
                    $userManager->insert($user);

                    header('Location:/user');
                    return null;
                }
            }
            return $this->twig->render('User/register.html.twig', [
                'errors' => $errors
            ]);
        } else {
            header('Location: / ');
            die();
        }
    }
}
