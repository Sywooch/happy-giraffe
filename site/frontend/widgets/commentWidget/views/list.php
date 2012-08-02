<?php
/**
 * @var CActiveDataProvider $dataProvider
 */

if ($type == 'guestBook') {
    $template = '
            <div class="default-comments" id="comments">
                <div class="comments-meta clearfix">
                    <div class="add-menu">
                         ' . (!Yii::app()->user->isGuest ? '<a href="javascript:void(0);" class="btn btn-orange a-right" onclick="addMenuToggle(this);"><span><span>Добавить запись<i class="arr-b"></i></span></span></a>
                            <ul style="display: none; ">
                                <li><a href="javascript:;" onclick="'.$this->objectName.'.newComment(event);addMenuToggle(this);">Текст</a></li>
                                <li><a href="#new_photo_comment_wrapper" onclick="'.$this->objectName.'.newPhotoComment(event);addMenuToggle(this);">Картинка</a></li>
                            </ul>
                        </div>' : '<a href="#login" class="btn btn-orange a-right fancy"  data-theme="white-square"><span><span>Добавить запись<i class="arr-b"></i></span></span></a>

                        </div>') . '
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
    if (Yii::app()->user->isGuest)
        $link = '<a href="#login" class="btn btn-orange a-right fancy" data-theme="white-square"><span><span>' . $this->button . '</span></span></a>';
    else{
        if ($this->readOnly)
                $link = '';
        else
            $link = '<a href="javascript:;" onclick="'.$this->objectName.'.newComment(event);" class="btn btn-orange a-right"><span><span>' . $this->button . '</span></span></a>';
    }

    $template = '
            <div class="default-comments" id="comments">
                <div class="comments-meta clearfix">
                    ' . $link . '
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

if ($this->type == 'guestBook') {
    $this->widget('HCommentListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '_comment',
        'itemsTagName' => 'ul',
        'summaryText' => 'показано: {start} - {end} из {count}',
        'afterAjaxUpdate' => "$('html, body').animate({scrollTop : $('.default-comments').offset().top}, 'fast')",
        'pager' => array(
            /*'class' => 'ext.yiinfinite-scroll.YiinfiniteScroller',
            'contentSelector' => 'ul.items',
            'itemSelector' => 'li.item',
            'loadingImg' => '/images/loader_01.gif',
            'loadingText' => 'Загрузка...',
            'donetext' => ' ',*/
            'class' => 'MyLinkPager',
            'header' => '',
        ),
        'id' => 'comment_list_' . $this->objectName,
        'template' => $template,
        'viewData' => array(
            'currentPage' => $dataProvider->pagination->currentPage,
        ),
        'popUp' => $this->popUp,
    ));
} else {
    $this->widget('HCommentListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '_comment',
        'itemsTagName' => 'ul',
        'summaryText' => 'показано: {start} - {end} из {count}',
        'afterAjaxUpdate' => "$('html, body').animate({scrollTop : $('.default-comments').offset().top}, 'fast')",
        'pager' => array(
            'class' => 'MyLinkPager',
            'header' => '',
        ),
        'id' => 'comment_list_' . $this->objectName,
        'template' => $template,
        'viewData' => array(
            'currentPage' => $dataProvider->pagination->currentPage,
        ),
        'popUp' => $this->popUp,
    ));
}
?>
