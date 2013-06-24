<?php
/**
 * @var CActiveDataProvider $dataProvider
 * @var $this NewCommentWidget
 */

NotificationRead::getInstance()->SetVisited();
$comments = $dataProvider->getData();

?><div class="comments-gray">
    <?php if ($dataProvider->totalItemCount > 3):?>
        <div class="comments-gray_t">
            <a href="<?=$this->model->getUrl() ?>" class="comments-gray_t-a">
                <span class="comments-gray_t-a-tx">Все комментарии (<?=$dataProvider->totalItemCount ?>)</span>
            </a>
        </div>
    <?php endif ?>
    <?php if (count($comments)):?>
        <div class="comments-gray_hold">
            <?php foreach ($comments as $comment) $this->render('_comment', array('data' => $comment)) ?>
        </div>
    <?php endif ?>
    <?php $this->render('form'); ?>
</div>