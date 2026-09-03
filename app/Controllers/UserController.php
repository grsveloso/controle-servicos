<?php

    require_once __DIR__ . '/../Models/User.php';

    class UserController
    {
        public function register()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'email' => $_POST['email'] ?? '',
                    'name' => $_POST['name'] ?? '',
                    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT) ?? ''
                ];
                
                User::create($data);

                header('Location: index.php');
            } else {
                require __DIR__ . '/../../views/auth/register.php';
            }
        }
    }