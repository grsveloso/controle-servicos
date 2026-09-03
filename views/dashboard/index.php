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
        <div>
            <h1>DASHBOARD</h1>
        </div>

        <div class="services">
            <div class="service-section">
                <h1>Últimos Serviços</h1>
                <p>1 - Troca de tela de notebook</p>
                <p>2 - Limpeza de teclado</p>
                <p>3 - Instalação de software</p>
            </div>

            <div class="service-section">
                <h1>Serviços Pendentes</h1>
                <p>1 - Troca de tela de notebook</p>
                <p>2 - Limpeza de teclado</p>
                <p>3 - Instalação de software</p>
            </div>
        </div>

        <div class="filters">
            <input type="text" placeholder="Nome">
            <input type="date" value="2024-08-15">
            <input type="date" value="2024-08-26">
            <button type="submit">Filtrar</button>
        </div>

        <div class="services-table">
            <div class="table-header">
                <strong>ID</strong>
                <strong>DESCRIÇÃO</strong>
                <strong>VALOR</strong>
                <strong>STATUS</strong>
            </div>
        </div>
    </div>
</body>
</html>
