<div class="b-article_in clearfix">
    <div class="user-status user-status__base">
        <div class="user-status_hold">
            <div class="user-status_tx"><?= strip_tags($model->text) ?></div>
        </div>
        <?php if ($model->moodModel) { ?>
            <div class="user-status_bottom">
                <div class="b-user-mood">
                    <div class="b-user-mood_hold">
                        <div class="b-user-mood_tx">Мое настроение -</div>
                    </div>
                    <div class="b-user-mood_img">
                        <img src="/images/widget/mood/<?= $model->moodId ?>.png" alt="<?= $model->moodModel->text ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
