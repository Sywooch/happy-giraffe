<div class="entry">

    <div class="entry-header">
        <?php if ($model->title): ?>
            <div class="entry-title_hold">
                <h1><?=$model->title?></h1>
            </div>
        <?php endif; ?>

        <noindex>
            <div class="clearfix">
                <div class="user">
                    <?php $this->widget('Avatar', array('user' => $model->author)); ?>
                </div>

                <?php $this->widget('FavouriteWidget', compact('model')); ?>
                <div class="meta">
                    <div class="time"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $model->created)?></div>
                </div>
            </div>
        </noindex>
    </div>

    <div class="entry-content">

        <div class="wysiwyg-content">

            <?=CHtml::image($model->getPreviewUrl(700, null, Image::WIDTH))?>

        </div>

    </div>
</div>