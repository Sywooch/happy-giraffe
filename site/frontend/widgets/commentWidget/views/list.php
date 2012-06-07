<?php
/**
 * @var CActiveDataProvider $dataProvider
 */

if ($type == 'guestBook') {
    $template = '
            <div class="default-comments">
                <div class="comments-meta clearfix">
                    <div class="add-menu">
                         ' . (!Yii::app()->user->isGuest ? '<a href="javascript:void(0);" class="btn btn-orange a-right" onclick="addMenuToggle(this);"><span><span>Добавить запись<i class="arr-b"></i></span></span></a>
                            <ul style="display: none; ">
                                <li><a href="javascript:;" onclick="Comment.newComment(event);addMenuToggle(this);">Текст</a></li>
                                <li><a  href="#new_photo_comment_wrapper" onclick="Comment.newPhotoComment(event);addMenuToggle(this);">Картинка</a></li>
                            </ul>
                        </div>' : '') . '
                    <div class="title">' . $this->title . '</div>
                    <div class="count">' . $dataProvider->totalItemCount . '</div>
                </div>
                {items}
            </div>
            <div class="pagination pagination-center clearfix">
                {pager}
            </div>
            ';
} else {
    $template = '
            <div class="default-comments">
                <div class="comments-meta clearfix">
                    ' . (!Yii::app()->user->isGuest && !$this->readOnly ? '<a href="javascript:;" onclick="Comment.newComment(event);" class="btn btn-orange a-right"><span><span>' . $this->button . '</span></span></a>' : '') . '
                    <div class="title">' . $this->title . '</div>
                    <div class="count">' . $dataProvider->totalItemCount . '</div>
                </div>
                {items}
            </div>
            <div class="pagination pagination-center clearfix">
                {pager}
            </div>
            ';
}

$this->widget('HCommentListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_comment',
    'itemsTagName' => 'ul',
    'summaryText' => 'показано: {start} - {end} из {count}',
    'afterAjaxUpdate' => "$('html, body').animate({scrollTop : $('.default-comments').offset().top}, 'fast');",
    'pager' => array(
        'class' => 'MyLinkPager',
        'header' => '',
    ),
    'id' => 'comment_list',
    'template' => $template,
    'viewData' => array(
        'currentPage' => $dataProvider->pagination->currentPage,
    ),
));
?>