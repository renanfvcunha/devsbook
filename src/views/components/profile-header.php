<div class="row">
    <div class="box flex-1 border-top-flat">
        <div class="box-body">
            <div
                class="profile-cover"
                <?php if ($user->cover): ?>
                    style="background-image: url('<?= $base ?>media/covers/<?= $user->cover ?>');"
                <?php else: ?>
                    style="background-image: url('https://i.picsum.photos/id/<?= $user->id ?>/850/313.jpg');"
                <?php endif; ?> 
            >
            </div>
            <div class="profile-info m-20 row">
                <div class="profile-info-avatar">
                    <a href="<?= $base ?>/profile/<?= $user->id ?>">
                        <?php if ($user->avatar): ?>
                        <img src="<?= $base ?>/media/avatars/<?= $user->avatar ?>" />
                        <?php else: ?>
                        <img src="https://api.adorable.io/avatars/50/<?= $user->slug ?>.png" />
                        <?php endif; ?>
                    </a>
                </div>
                <div class="profile-info-name">
                    <div class="profile-info-name-text">
                        <a href="<?= $base ?>/profile/<?= $user->id ?>"><?= $user->name ?></a>
                    </div>
                    <?php if($user->city): ?>
                    <div class="profile-info-location"><?= $user->city ?></div>
                    <?php endif; ?>
                </div>
                <div class="profile-info-data row">
                    <div class="profile-info-item m-width-20">
                        <a href="<?= $base ?>/profile/<?= $user->id?>/friends">
                            <div id="followers" class="profile-info-item-n"><?= count($user->followers) ?></div>
                            <div class="profile-info-item-s">Seguidores</div>
                        </a>
                    </div>
                    <div class="profile-info-item m-width-20">
                        <a href="<?= $base ?>/profile/<?= $user->id?>/friends">
                            <div class="profile-info-item-n"><?= count($user->following) ?></div>
                            <div class="profile-info-item-s">Seguindo</div>
                        </a>
                    </div>
                    <div class="profile-info-item m-width-20">
                        <a href="<?= $base ?>/profile/<?= $user->id?>/pictures">
                            <div class="profile-info-item-n"><?= count($user->photos) ?></div>
                            <div class="profile-info-item-s">Fotos</div>
                        </a>
                    </div>
                    <?php if($user->id !== $loggedUser->id): ?>
                    <div class="profile-info-item m-width-20">
                        <button id="follow" class="button" userid="<?= $user->id ?>">
                            <?= !$isFollowing ? 'Seguir' : 'Deixar de Seguir' ?>
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>