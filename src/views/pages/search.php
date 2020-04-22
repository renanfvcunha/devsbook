<?= $render('header', ['user' => $loggedUser]) ?>
<section class="container main">
    <?= $render('sidebar', ['activeMenu' => 'search']) ?>
    <section class="feed">
        <div class="feed mt-10">
            <h1>Você pesquisou por: <?= $search ?></h1>
            <div class="row">
                <div class="column pr-5">
                    <?php if($users): ?>
                        <div class="full-friend-list">
                            <?php foreach($users as $user): ?>
                            <div class="friend-icon">
                                <a href="<?= $base ?>/profile/<?= $user->id ?>">
                                    <div class="friend-icon-avatar">
                                        <?php if ($user->avatar): ?>
                                        <img src="<?= $base ?>/media/avatars/<?= $user->avatar ?>" />
                                        <?php else: ?>
                                        <img src="https://api.adorable.io/avatars/55/<?= $user->slug ?>.png" />
                                        <?php endif; ?>
                                    </div>
                                    <div class="friend-icon-name">
                                        <?= $user->name ?>
                                    </div>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <h2>Sua busca não obteve resultados.</h2>
                    <?php endif; ?>
                </div>
                <div class="column side pl-5">
                    <?= $render('rightSide') ?>
                </div>
            </div>
        </div>
    </section>
</section>
<?= $render('footer') ?>
