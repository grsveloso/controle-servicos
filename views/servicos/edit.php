<html>
    <head>
        <link rel="stylesheet" href="/style.css">
        <title>Cadastrar Serviço</title>
    </head>
    <body>
        <div class="center-form">
            <form method="POST" action="index.php?action=update_service">
                <h1>Editar Serviço</h1>
                <input type="hidden" id="id_service" name="id_service" value="<?= $service['id_service'] ?>">
                <input type="text" id="description" name="description" value="<?= $service['description'] ?>" placeholder="Descrição"><br><br>
                <input type="number" id="price" name="price" value="<?= $service['price'] ?>" placeholder="Preço"><br><br>
                <button type="submit" class="center-form-button">Atualizar</button>
            </form>
        </div>
    </body>
</html>