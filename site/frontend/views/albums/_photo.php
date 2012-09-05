<li>
    <div class="img">
        <a href="javascript:void(0)" data-id="<?=$data->id?>">
            <?=CHtml::image('http://happy-giraffe.dev/images/banner_02.png')?>
            <span class="btn">Посмотреть</span>
        </a>
        <?php if (Yii::app()->user->id == $this->user->id): ?>
            <div class="actions">
                <?=CHtml::link('', array('albums/updatePhoto', 'id' => $data->id), array('class' => 'edit fancy tooltip', 'title' => 'Редактировать'))?>
                <?php $this->widget('site.frontend.widgets.removeWidget.RemoveWidget', array(
                    'model' => $data,
                    'callback' => 'Album.removePhoto',
                    'author' => !Yii::app()->user->isGuest && Yii::app()->user->id == $data->author_id,
                )); ?>
            </div>
        <?php endif; ?>
    </div>
    <?php if ($data->title): ?>
        <div class="item-title"><?=$data->title?></div>
    <?php endif; ?>
</li>