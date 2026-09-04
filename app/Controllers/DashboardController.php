<?php

    require_once __DIR__ . '/../Models/User.php';
    require_once __DIR__ . '/../Models/Service.php';
    require_once __DIR__ . '/../Services/MailService.php';

    class DashboardController
    {
        public function index()
        {
            session_start();
            
            if(!isset($_SESSION['id_user'])) {
                header('Location: index.php?action=login');
                exit();
            }

            $dateStart = $_GET['date_start'] ?? null;
            $dateEnd = $_GET['date_end'] ?? null;
            $description = $_GET['description'] ?? null;
            $status = $_GET['status'] ?? null;
            $name = $_GET['name'] ?? null;

            $services = Service::getServices($dateStart, $dateEnd, $description, $status, $name);

            require __DIR__ . '/../../views/dashboard/index.php';
        }

        public function createService()
        {
            session_start();

            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                $price = (float) $_POST['price'] ?? 0;
                $commission = Service::calculateCommision($price);

                if(empty($_POST['description']) || empty($_POST['price'])) {
                    $_SESSION['error_message'] = "Descrição e Preço são obrigatórios.";
                    header('Location: index.php?action=dashboard');
                    exit();
                }

                $data = [
                    'description' => $_POST['description'] ?? '',
                    'price' => $price,
                    'commission_user' => $commission,
                    'user_id_user' => $_SESSION['id_user'] ?? null
                ];
                
                Service::create($data);

                $_SESSION['success'] = "Serviço cadastrado com sucesso.";

                header('Location: index.php?action=dashboard');
            } else {
                require __DIR__ . '/../../views/servicos/create.php';
            }
        }

        public function finishService()
        {
            $serviceId = $_GET['id_service'] ?? null;

            Service::finishServices($serviceId);
            $service = Service::getServiceWithUser($serviceId);
            MailService::sendServiceFinishedEmail($service['email'], $service['name'], $service['description'], $service['price'], $service['commission_user']);

            header('Location: index.php?action=dashboard');
            exit();
        }

        public function deleteService()
        {
            $serviceId = $_GET['id_service'] ?? null;

            Service::deleteService($serviceId);

            header('Location: index.php?action=dashboard');
            exit();
        }

        public function editService()
        {
            $serviceId = $_GET['id_service'] ?? null;

            $service = Service::getServiceById($serviceId);

            require __DIR__ . '/../../views/servicos/edit.php';
        }

        public function updateService()
        {
            $serviceId = $_POST['id_service'] ?? null;
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';

            Service::updateService($serviceId, $description, $price);

            header('Location: index.php?action=dashboard');
            exit();
        }
    }