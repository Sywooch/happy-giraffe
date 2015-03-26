<div class="b-article_in clearfix">
    <div class="user-status user-status__base">
        <div class="user-status_hold">
            <a class="user-status_tx" href="<?= $status->url ?>"><?= strip_tags($status->text) ?></a>
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
</div>