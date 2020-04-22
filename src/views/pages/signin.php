<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title>Login - Devsbook</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1" />
    <link rel="stylesheet" href="<?= $base ?>/assets/css/login.css" />
</head>

<body>
    <header>
        <div class="container">
            <a href=""><img src="<?= $base ?>/assets/images/devsbook_logo.png" /></a>
        </div>
    </header>
    <section class="container main">
        <form id="signin">
            <div class="flash"></div>
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

            <button class="button" type="submit">Entrar</button>

            <a href="<?= $base ?>/signup">Ainda não tem conta? Cadastre-se</a>
        </form>
    </section>
    <script type="text/javascript" src="<?= $base ?>/assets/js/signin.js"></script>
</body>

</html>