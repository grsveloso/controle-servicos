<?php

    require __DIR__ . '/../Controllers/AuthController.php';
    require __DIR__ . '/../Controllers/UserController.php';
    require __DIR__ . '/../Controllers/DashboardController.php';

    $authController = new AuthController();
    $userController = new UserController();
    $dashboardController = new DashboardController();

    $action = $_GET['action'] ?? 'login';

    switch ($action) {
        case 'login':
            $authController->login();
            break;
        case 'register':
            $userController->register();
            break;
        case 'dashboard':
            $dashboardController->index();
            break;
        case 'create_service':
            $dashboardController->createService();
            break;
        case 'finish_service':
            $dashboardController->finishService();
            break;
        case 'delete_service':
            $dashboardController->deleteService();
            break;
        case 'edit_service':
            $dashboardController->editService();
            break;
        case 'update_service':
            $dashboardController->updateService();
            break;
        default:
            http_response_code(404);
            echo "Página não encontrada.";
            break;
    }