<?php
    require_once __DIR__ . '/../../app/Models/Service.php';

    $lastServices = Service::getLastServices();
    $pendingServices = Service::getPendingServices();
?>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/style.css">
</head>
<body>

    <div class="sidebar">
        <h4>Logado como:</h4>
        <h4><?php echo $_SESSION['name'] ?? ''; ?></h4>
        <br>
        <a href="index.php?action=create_service" class="create-button">Cadastrar Serviço</a>
    </div>

    <div style="margin-left:15%">
        <?php

            if (isset($_SESSION['success'])) {
                echo '<div class="success-message">' . $_SESSION['success'] . '</div>';
                unset($_SESSION['success']);
            }
    
            if (isset($_SESSION['error_message'])) {
                echo '<div class="error-message">' . $_SESSION['error_message'] . '</div>';
                unset($_SESSION['error_message']);
            }
        ?>
    
        <div>
            <h1>DASHBOARD</h1>
        </div>

        <div class="services">
            <div class="service-section">
                <h1>Últimos Serviços</h1>
                <?php foreach ($lastServices as $lastService): ?>
                    <p><?php echo $lastService['id_service'] . ' - ' . $lastService['description']; ?></p>
                <?php endforeach; ?>
            </div>

            <div class="service-section">
                <h1>Serviços Pendentes</h1>
                <?php foreach ($pendingServices as $pendingService): ?>
                    <p><?php echo $pendingService['id_service'] . ' - ' . $pendingService['description']; ?></p>
                <?php endforeach; ?>
            </div>
        </div>

        <form method="GET" action="index.php">
            <div class="filters">
                <input type="hidden" name="action" value="dashboard">
                <input type="text" name="description" placeholder="Serviço">
                <input type="date" name="date_start">
                <input type="date" name="date_end">
                <select name="status">
                    <option value="">Todos</option>
                    <option value="PENDENTE">Pendente</option>
                    <option value="FINALIZADO">Finalizado</option>
                </select>
                <input type="text" name="name" placeholder="Funcionário">
                <button type="submit">Filtrar</button>
            </div>
        </form>

        <div class="services-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>DESCRIÇÃO</th>
                        <th>VALOR</th>
                        <th>STATUS</th>
                        <th>FUNCIONÁRIO</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td><?php echo $service['id_service']; ?></td>
                            <td><?php echo $service['description']; ?></td>
                            <td><?php echo 'R$' . number_format($service['price'], 2, ',', '.'); ?></td>
                            <td><?php echo $service['status']; ?></td>
                            <td><?php echo $service['name']; ?></td>
                            <td>
                                <a href="index.php?action=edit_service&id_service=<?php echo $service['id_service']; ?>" class="edit-button">Editar</a>
                                <?php if ($service['status'] !== 'FINALIZADO'): ?>
                                    <a href="index.php?action=finish_service&id_service=<?php echo $service['id_service']; ?>" class="finish-button">Finalizar</a>
                                <?php endif; ?>
                                <a href="index.php?action=delete_service&id_service=<?php echo $service['id_service']; ?>" class="delete-button">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
