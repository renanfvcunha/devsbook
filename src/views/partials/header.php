<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title>Devsbook</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1" />
    <link rel="stylesheet" href="<?= $base ?>assets/css/style.css" />
</head>

<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="<?= $base ?>"><img src="<?= $base ?>assets/images/devsbook_logo.png" /></a>
            </div>
            <div class="head-side">
                <div class="head-side-left">
                    <div class="search-area">
                        <form method="GET" action="<?= $base ?>search">
                            <input type="search" placeholder="Pesquisar" name="q" />
                        </form>
                    </div>
                </div>
                <div class="head-side-right">
                    <a href="<?= $base ?>profile" class="user-area">
                        <div class="user-area-text"><?= $user->name ?></div>
                        <div class="user-area-icon">
                        <?php if ($user->avatar): ?>
                            <img src="<?= $base ?>media/avatars/<?= $user->avatar ?>" />
                        <?php else: ?>
                            <img src="https://api.adorable.io/avatars/24/<?= $user->slug ?>.png" />
                        <?php endif; ?>
                        </div>
                    </a>
                    <a href="<?= $base ?>signout" class="user-logout">
                        <img src="<?= $base ?>assets/images/power_white.png" />
                    </a>
                </div>
            </div>
        </div>
    </header>