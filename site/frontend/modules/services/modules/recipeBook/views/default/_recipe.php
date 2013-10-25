<div class="entry">

    <?=CHtml::link($data->title, $data->url, array('class' => 'entry-title'))?>

    <div class="entry-header">

        <?php $this->widget('Avatar', array('user' => $data->author)); ?>

        <div class="meta">
            <div class="time"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $data->created)?></div>
            <div class="seen">Просмотров:&nbsp;<span><?=PageView::model()->viewsByPath($data->url)?></span></div><br>
            <a href="<?=$data->getUrl(true)?>">Комментариев: <?php echo $data->commentsCount; ?></a>
        </div>
        <div class="clear"></div>
    </div>

    <div class="entry-content">

        <div class="disease-title">
            <span>От болезни</span> <?=CHtml::link($data->disease->title, array('/services/childrenDiseases/default/view', 'id' => $data->disease->slug))?>
        </div>

        <div class="wysiwyg-content">

            <h3>Приготовление</h3>

            <p><?=Str::truncate(strip_tags($data->text), 500)?> <?=CHtml::link('Читать весь рецепт<i class="icon"></i>', $data->url, array('class' => 'read-more'))?></p>

        </div>

    </div>

</div>