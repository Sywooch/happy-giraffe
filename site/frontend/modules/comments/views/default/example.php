<?php
$commentsWidget = $this->createWidget('site\frontend\modules\comments\widgets\CommentWidget', array('model' => $model))
?>
<div class="b-main_col-article">
    <!-- comments-->
    <div class="comments comments__buble">
        <div class="comments-menu">
            <ul data-tabs="tabs" class="comments-menu_ul">
                <li class="comments-menu_li active"><a href="#commentsList" data-toggle="tab" class="comments-menu_a comments-menu_a__comments">Комментарии <?= $commentsWidget->count ?> </a></li>
                <li class="comments-menu_li"><a href="#likesList" data-toggle="tab" class="comments-menu_a comments-menu_a__likes">Нравится 865</a></li>
                <li class="comments-menu_li"><a href="#favoritesList" data-toggle="tab" class="comments-menu_a comments-menu_a__favorites">Закладки 865</a></li>
            </ul>
            <div class="tab-content">
                <?php $commentsWidget->run(); ?>
            </div>
        </div>
    </div>
</div>
