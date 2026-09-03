<?php

    require_once __DIR__ . '/../Models/User.php';
    require_once __DIR__ . '/../Models/Service.php';

    class DashboardController
    {
        public function index()
        {
            session_start();
            
            if(!isset($_SESSION['id_user'])) {
                header('Location: index.php?action=login');
                exit();
            }

            require __DIR__ . '/../../views/dashboard/index.php';
        }

        public function createService()
        {
            session_start();

            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'description' => $_POST['description'] ?? '',
                    'price' => $_POST['price'] ?? '',
                    'user_id_user' => $_SESSION['id_user'] ?? null
                ];
                
                Service::create($data);

                header('Location: index.php?action=dashboard');
            } else {
                require __DIR__ . '/../../views/servicos/create.php';
            }
        }
    }