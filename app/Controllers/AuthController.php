<?php

    require_once __DIR__ . '/../Models/User.php';

    class AuthController
    {

        public function login()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';
                $name = $_POST['name'] ?? '';

                $user = User::getUserByEmail($email);

                if($user && password_verify($password, $user['password'])){
                    session_start();

                    $_SESSION['id_user'] = $user['id_user'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['name'] = $user['name'];

                    header('Location: index.php?action=dashboard');
                } else {
                    echo "Ops, Email ou Senha inválido";
                }
            } else {
                require __DIR__ . '/../../views/auth/login.php';
            }
        }
    }