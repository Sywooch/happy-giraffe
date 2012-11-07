<div class="col-1">

    <?php $this->renderPartial('_friends_sidebar'); ?>

</div>

<div class="col-23 clearfix">

    <div class="content-title-new"><?=($this->user->id == Yii::app()->user->id) ? 'Мои друзья' : 'Друзья'?></div>

    <?php if ($dataProvider->itemCount > 0 || $this->user->id !== Yii::app()->user->id): ?>
    <?php
        $this->widget('zii.widgets.CListView', array(
            'id' => 'friendRequestList',
            'ajaxUpdate' => true,
            'dataProvider' => $dataProvider,
            'itemView' => '_friend',
            'itemsTagName' => 'ul',
            'template' =>
            '
                                <div class="friends clearfix">
                                    {items}
                                </div>
                                <div class="pagination pagination-center clearfix">
                                    {pager}
                                </div>
                            ',
            'pager' => array(
                'class' => 'MyLinkPager',
                'header' => '',
            ),
        ));
        ?>
    <?php else:?>
        <?php $this->renderPartial('_cap', array('title' => 'У вас пока 0 новых друзей')); ?>
    <?php endif; ?>
</div>