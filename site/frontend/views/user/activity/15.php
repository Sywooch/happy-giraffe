<?php
    $content = BlogContent::model()->full()->findByPk($action->data['id']);
?>

<div class="user-post list-item">

    <div class="box-title">Добавил запись</div>

    <ul>
        <li>
            <div class="added-to">
                <span>в свой <?=CHtml::link('блог', array('blog/list', 'user_id' => $this->user->id))?></span>
            </div>
            <div class="item-title"><?=CHtml::link($content->title, $content->url)?></div>
            <div class="added-date"><?=Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", $content->created)?></div>
            <?php if (($image = $content->contentImage) !== false): ?>
                <div class="img">
                    <?=CHtml::link(CHtml::image($image), $content->url)?>
                </div>
            <?php endif; ?>
            <div class="content">
                <p><?=$content->contentText?> <?=CHtml::link('Читать всю запись<i class="icon"></i>', $content->url, array('class' => 'read-more'))?></p>
            </div>
        </li>
    </ul>

</div>