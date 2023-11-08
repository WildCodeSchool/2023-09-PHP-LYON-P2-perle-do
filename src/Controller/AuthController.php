<?php

namespace App\Controller;

use App\Model\AuthManager;

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //      @todo make some controls and if errors send them to the view
            $credentials = $_POST;
            $userManager = new AuthManager();
            if ($userManager->insert($credentials)) {
                return $this->login();
            }
        }
        return $this->twig->render('User/register.html.twig');
    }

    public function show(int $id): string
    {
        $userManager = new authManager();
        $user = $userManager->selectOneById($id);

        return $this->twig->render('User/show.html.twig', ['user' => $user]);
    }

    public function index(): string
    {
        $userManager = new AuthManager();
        $users = $userManager->selectAll('id');

        return $this->twig->render('User/index.html.twig', ['users' => $users]);
    }

    public function edit(int $id): ?string
    {
        $userManager = new AuthManager();
        $user = $userManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $user = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, update and redirection
            $userManager->update($user);

            header('Location: /register/show?id=' . $id);

            // we are redirecting so we don't want any content rendered
            return null;
        }

        return $this->twig->render('User/edit.html.twig', [
            'user' => $user,
        ]);
    }

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $userManager = new AuthManager();
            $userManager->delete((int)$id);

            header('Location:/register');
        }
    }
}
