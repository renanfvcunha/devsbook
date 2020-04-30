<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title>Login - Devsbook</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1" />
    <link rel="stylesheet" href="<?= $base ?>assets/css/login.css" />
</head>

<body>
    <header>
        <div class="container">
            <a href=""><img src="<?= $base ?>assets/images/devsbook_logo.png" /></a>
        </div>
    </header>
    <section class="container main">
        <form id="signup">
            <div class="flash"></div>
            <div class="loading">Validando Dados...</div>
            <input
                placeholder="Nome Completo"
                class="input"
                type="text"
                name="name"
                required
            />

            <input
                placeholder="E-mail"
                class="input"
                type="email"
                name="email"
                required
            />

            <input
                placeholder="Senha"
                class="input"
                type="password"
                name="password"
                required
            />

            <input
                placeholder="Data de Nascimento"
                class="input"
                type="text"
                name="birthdate"
                id="birthdate"
                required
            />

            <button class="button" type="submit">Cadastrar</button>

            <a href="<?= $base ?>signin">Já tem conta? Entrar</a>
        </form>
    </section>
    <script type="text/javascript" src="<?= $base ?>assets/js/signup.js"></script>
</body>

</html>