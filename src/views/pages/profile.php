<?= $render('header', ['user' => $loggedUser]) ?>
<section class="container main">
    <?= $render('sidebar', ['activeMenu' => 'profile']) ?>
    <section class="feed">
        <?= $render('profile-header', [
            'user' => $user,
            'loggedUser' => $loggedUser,
            'isFollowing' => $isFollowing
        ]) ?>
        <div class="row">
            <div class="column side pr-5">
                <div class="box">
                    <div class="box-body">
                        <div class="user-info-mini">
                            <img src="<?= $base ?>assets/images/calendar.png" />
                            <?= date('d/m/Y', strtotime($user->birthdate)) ?> (<?= $user->age ?> anos)
                        </div>
                        <?php if($user->city): ?>
                            <div class="user-info-mini">
                                <img src="<?= $base ?>assets/images/pin.png" />
                                <?= $user->city ?>
                            </div>
                        <?php endif; ?>
                        <?php if($user->work): ?>
                            <div class="user-info-mini">
                                <img src="<?= $base ?>assets/images/work.png" />
                                <?= $user->work ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header m-10">
                        <div class="box-header-text">
                            Seguindo
                            <span>(<?= count($user->following) ?>)</span>
                        </div>
                        <div class="box-header-buttons">
                            <a href="<?= $base ?>profile/<?= $user->id ?>/friends">Ver Todos</a>
                        </div>
                    </div>
                    <div class="box-body friend-list">
                        <?php for($i=0; $i<9; $i++): ?>
                            <?php if(isset($user->following[$i])): ?>
                            <div class="friend-icon">
                                <a href="<?= $base ?>profile/<?= $user->following[$i]->id ?>">
                                    <div class="friend-icon-avatar">
                                        <?php if($user->following[$i]->avatar): ?>
                                        <img src="<?= $base ?>media/avatars/<?= $user->following[$i]->avatar ?>" />
                                        <?php else: ?>
                                        <img src="https://api.adorable.io/avatars/55/<?= $user->following[$i]->slug ?>.png" />
                                        <?php endif; ?>
                                    </div>
                                    <div class="friend-icon-name">
                                        <?= $user->following[$i]->name ?>
                                    </div>
                                </a>
                            </div>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
            <div class="column pl-5">
                <div class="box">
                    <div class="box-header m-10">
                        <div class="box-header-text">
                            Fotos
                            <span>(<?= count($user->photos) ?>)</span>
                        </div>
                        <div class="box-header-buttons">
                            <a href="<?= $base ?>profile/<?= $user->id ?>/pictures">Ver Todas</a>
                        </div>
                    </div>
                    <div class="box-body row m-20">
                        <?php for ($i=0; $i < 4; $i++): ?>
                            <?php if (isset($user->photos[$i])): ?>
                            <div class="user-photo-item">
                                <a href="#modal-<?= $user->photos[$i]->id ?>" rel="modal:open">
                                    <img src="<?= $base ?>media/uploads/<?= $user->photos[$i]->body ?>" />
                                </a>
                                <div id="modal-<?= $user->photos[$i]->id ?>" style="display:none">
                                    <img src="<?= $base ?>media/uploads/<?= $user->photos[$i]->body ?>" />
                                </div>
                            </div>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                </div>
                <?php if($user->id === $loggedUser->id): ?>
                <?= $render('feed-editor', ['user' => $loggedUser]) ?>
                <?php endif; ?>

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
                        href="<?= $base ?>profile/<?= $user->id ?>?p=<?= $q ?>"
                    >
                        <?= $q ?>
                    </a>
                <?php endfor; ?>
                </div>
            </div>
        </div>
    </section>
</section>
<?= $render('footer') ?>
