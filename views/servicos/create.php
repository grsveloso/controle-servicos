<html>
    <head>
        <link rel="stylesheet" href="/style.css">
        <title>Cadastrar Serviço</title>
    </head>
    <body>
        <div class="center-form">
            <form method="POST" action="index.php?action=create_service">
                <h1>Cadastrar Novo Serviço</h1>
                <input type="text" id="description" name="description" placeholder="Descrição"><span style="color: red; font-size: 12px;">* Obrigatório</span><br><br>
                <input type="number" id="price" name="price" placeholder="Preço"><span style="color: red; font-size: 12px;">* Obrigatório</span><br><br>
                <button type="submit" class="center-form-button">Cadastrar</button>
            </form>
        </div>
    </body>
</html>