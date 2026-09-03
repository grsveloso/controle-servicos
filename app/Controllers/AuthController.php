<?php

    require_once __DIR__ . '/../Models/User.php';

    class AuthController
    {

        public function login()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';

                $user = User::getUserByEmail($email);

                if($user && password_verify($password, $user['password'])){
                    session_start();

                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['email'] = $user['email'];

                    header('Location: index.php?action=dashboard');
                } else {
                    echo "Credenciais inválidas.";
                }
            } else {
                require __DIR__ . '/../../views/auth/login.php';
            }
        }
    }