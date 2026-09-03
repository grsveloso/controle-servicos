<html>
    <head>
        <link rel="stylesheet" href="/style.css">
    </head>
    <body>
        <div class="center-form">
            <h1>Cadastrar Novo Usuário</h1>
            <form method="POST" action="index.php?action=register">
                <input type="text" id="email" name="email" placeholder="email@email.com" style="width: 360px;"><br><br>
                <input type="text" id="name" name="name" placeholder="Fulano de Tal" style="width: 360px;"><br><br>
                <input type="password" id="password" name="password" placeholder="***************" style="width: 360px;"><br><br>
                <button type="submit" class="login-button">Cadastrar</button>
            </form>
        </div>
</html>