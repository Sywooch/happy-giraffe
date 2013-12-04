<div>
    <div class="left">
        <div class="photo-window_contest-logo">
            <a href="<?=$contest->url?>">
                <img src="/images/contest/photo-window_contest-logo_<?=$contest->id?>.png" alt="">
            </a>
        </div>
    </div>

    <div class="right">
        <?php Yii::app()->controller->renderPartial('_meter', compact('attach')); ?>
    </div>
</div>