<?php
/**
 * @var CActiveDataProvider $dataProvider
 */
?>
<div class="default-comments">
    <div class="comments-meta">
        <?php if(!Yii::app()->user->isGuest): ?>
            <a href="#new_comment_wrapper" onclick="Comment.newComment(event);" class="btn btn-orange a-right"><span><span>Добавить запись</span></span></a>
        <?php endif; ?>
        <div class="title"><?php echo $this->title; ?></div>
        <div class="count"><?php echo $dataProvider->totalItemCount; ?></div>
    </div>
    <?php
    $this->widget('MyListView', array(
        'dataProvider' => $dataProvider,
        //'summaryText' => 'Показано',
        'itemView' => '_comment', // refers to the partial view named '_post'
        'summaryText' => 'показано: {start} - {end} из {count}',
        'afterAjaxUpdate' => "$('html, body').animate({scrollTop : $('.default-comments').offset().top}, 'fast');",
        'pager' => array(
            'class' => 'MyLinkPager',
            'header' => 'Страницы',
        ),
        'id' => 'comment_list',
        'template' => '<ul>{items}</ul>
                <div class="pagination pagination-center clearfix">
                    {summary}
                    {pager}
                </div>
            ',
        'viewData' => array(
            'currentPage' => $dataProvider->pagination->currentPage,
        ),
    ));
    ?>
</div>