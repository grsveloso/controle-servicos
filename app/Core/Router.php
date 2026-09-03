<?php

    require __DIR__ . '/../Controllers/AuthController.php';
    require __DIR__ . '/../Controllers/UserController.php';

    $authController = new AuthController();
    $userController = new UserController();

    $action = $_GET['action'] ?? 'login';

    switch ($action) {
        case 'login':
            $authController->login();
            break;
        case 'register':
            $userController->register();
            break;
        default:
            http_response_code(404);
            echo "Página não encontrada.";
            break;
    }