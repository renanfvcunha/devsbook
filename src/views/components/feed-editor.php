<div class="box feed-new">
    <div class="box-body">
        <div class="feed-new-editor m-10 row">
            <div class="feed-new-avatar">
                <?php if ($loggedUser->avatar): ?>
                <img src="<?= $base ?>media/avatars/<?= $user->avatar ?>" />
                <?php else: ?>
                <img src="https://api.adorable.io/avatars/50/<?= $user->slug ?>.png" />
                <?php endif; ?>
            </div>
            <div class="feed-new-input-placeholder">O que você está pensando, <?= $user->name ?>?</div>
            <div class="feed-new-input" contenteditable="true"></div>
            <div class="feed-new-send">
                <img src="<?= $base ?>assets/images/send.png" />
            </div>
            <form class="feed-new-form" method="post" action="<?= $base ?>post/new">
                <input type="hidden" name="body">
            </form>
        </div>
    </div>
</div>