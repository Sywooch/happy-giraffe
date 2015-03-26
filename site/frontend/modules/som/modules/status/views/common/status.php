<div class="user-status user-status__base">
    <div class="user-status_hold">
        <div class="user-status_tx"><?= strip_tags($status->text) ?></div>
    </div>
    <?php if ($status->moodId) { ?>
        <div class="user-status_bottom">
            <div class="b-user-mood">
                <div class="b-user-mood_hold">
                    <div class="b-user-mood_tx">Мое настроение -</div>
                </div>
                <div class="b-user-mood_img">
                    <img src="/images/widget/mood/<?= $status->moodId ?>.png">
                </div>
            </div>
        </div>
    <?php } ?>
</div>
