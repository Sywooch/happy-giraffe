<?php
/**
 * @var CActiveDataProvider $dataProvider
 */
?>
<div class="default-comments">
    <?php
    if ($type == 'guestBook'){
        $template = '
            <div class="comments-meta">
                    ' . (!Yii::app()->user->isGuest ? '<a href="#new_comment_wrapper" onclick="Comment.newComment(event);" class="btn btn-orange a-right"><span><span>' . $this->button . '</span></span></a>
                    <a href="#new_photo_comment_wrapper" onclick="Comment.newPhotoComment(event);" class="btn btn-orange a-right"><span><span>Отправить Фото</span></span></a>' : '') . '
                    <div class="title">' . $this->title . '</div>
                    <div class="count">' . $dataProvider->totalItemCount . '</div>
                </div>
                <ul>{items}</ul>
                <div class="pagination pagination-center clearfix">
                    {summary}
                    {pager}
                </div>
            ';
    }else{
        $template = '
            <div class="comments-meta">
                    ' . (!Yii::app()->user->isGuest ? '<a href="#new_comment_wrapper" onclick="Comment.newComment(event);" class="btn btn-orange a-right"><span><span>' . $this->button . '</span></span></a>' : '') . '
                    <div class="title">' . $this->title . '</div>
                    <div class="count">' . $dataProvider->totalItemCount . '</div>
                </div>
                <ul>{items}</ul>
                <div class="pagination pagination-center clearfix">
                    {summary}
                    {pager}
                </div>
            ';
    }

    $this->widget('MyListView', array(
        'dataProvider' => $dataProvider,
        //'summaryText' => 'Показано',
        'itemView' => '_comment',
        'summaryText' => 'показано: {start} - {end} из {count}',
        'afterAjaxUpdate' => "$('html, body').animate({scrollTop : $('.default-comments').offset().top}, 'fast');",
        'pager' => array(
            'class' => 'MyLinkPager',
            'header' => 'Страницы',
        ),
        'id' => 'comment_list',
        'template' => $template,
        'viewData' => array(
            'currentPage' => $dataProvider->pagination->currentPage,
        ),
    ));
    ?>
</div>