<?= $render('header', ['user' => $loggedUser]) ?>
<section class="container main">
    <?= $render('sidebar', ['activeMenu' => 'home']) ?>
    <section class="feed mt-10">
        <div class="row">
            <div class="column pr-5">
                <?= $render('feed-editor', ['user' => $loggedUser]) ?>
                <?php foreach ($feed['posts'] as $feedItem): ?>
                <?= $render('feed-item', [
                    'data' => $feedItem,
                    'loggedUser' => $loggedUser
                ]) ?>
                <?php endforeach; ?>
                
                <div class="feed-pagination">
                <?php for($q=1; $q<$feed['totalPages'] + 1; $q++): ?>
                    <a
                        class="<?= ($q === $page + 1 ? 'active' : '' ) ?>"
                        href="<?= $base ?>?p=<?= $q ?>"
                    >
                        <?= $q ?>
                    </a>
                <?php endfor; ?>
                </div>
            </div>
            <div class="column side pl-5">
                <?= $render('rightSide') ?>
            </div>
        </div>
    </section>
</section>
<?= $render('footer') ?>
