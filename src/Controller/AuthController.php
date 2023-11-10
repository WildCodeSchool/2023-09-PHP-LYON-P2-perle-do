<?php

namespace App\Controller;

use App\Model\AuthManager;
use App\Service\ValidationService;

class AuthController extends AbstractController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credentials = array_map('trim', $_POST);
            //      @todo make some controls on email and password fields and if errors, send them to the view
            $userManager = new AuthManager();
            $user = $userManager->selectOneByLogin($credentials['pseudo']);
            if ($user && password_verify($credentials['password'], $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: /');
                exit();
            }
        }
        return $this->twig->render('Auth/index.html.twig');
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        header('Location: /');
    }

    public function register()
    {
        if (isset($_SESSION['user_id']) === true) {
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
                    $authManager = new AuthManager();
                    $authManager->insert($user);

                    header('Location:/register');
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


    public function show(int $id): string
    {
        if (isset($_SESSION['user_id']) === true) {
            $userManager = new authManager();
            $user = $userManager->selectOneById($id);

            return $this->twig->render('User/show.html.twig', ['user' => $user]);
        } else {
            header('Location: /');
            die();
        }
    }

    public function indexAuth(): string
    {
        if (isset($_SESSION['user_id']) === true) {
            $userManager = new AuthManager();
            $users = $userManager->selectAll('id');

            return $this->twig->render('User/index.html.twig', ['users' => $users]);
        } else {
            header('Location: /');
            die();
        }
    }

    public function edit(int $id): ?string
    {
        if (isset($_SESSION['user_id']) === true) {
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
                    $authManager = new AuthManager();
                    $id = $authManager->update($user);

                    header('Location:/register/show?id=' . $id);
                    return null;
                }
            }
            return $this->twig->render('User/edit.html.twig', [
                'errors' => $errors
            ]);
        } else {
            header('Location: /');
            die();
        }
    }

    public function delete(): void
    {
        if (isset($_SESSION['user_id']) === true) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = trim($_POST['id']);
                $userManager = new AuthManager();
                $userManager->delete((int)$id);

                header('Location:/register');
            }
        } else {
            header('Location: /');
            die();
        }
    }
}
