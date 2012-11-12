<div class="col-1">

    <?php $this->renderPartial('_friends_sidebar'); ?>

</div>

<div class="col-23 clearfix">

    <div class="content-title-new"><?=($direction == 'incoming') ? 'Хотят дружить' : 'Я хочу дружить'?></div>

    <?php if ($dataProvider->itemCount > 0): ?>
        <?php
            $this->widget('zii.widgets.CListView', array(
                'id' => 'friendRequestList',
                'dataProvider' => $dataProvider,
                'itemView' => '_friendRequest',
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
                'viewData' => array(
                    'direction' => $direction,
                ),
            ));
        ?>
    <?php else: ?>
        <?php $this->renderPartial('_cap', array('title' => ($direction == 'incoming') ? 'У вас пока 0 новых предложений дружбы' : 'Вы еще никому не выслали предложеине дружбы')); ?>
    <?php endif; ?>

</div>