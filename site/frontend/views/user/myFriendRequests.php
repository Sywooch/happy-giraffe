<div class="col-1">

    <?php $this->renderPartial('_friends_sidebar'); ?>

</div>

<div class="col-23 clearfix">

    <div class="content-title-new"><?=($direction == 'incoming') ? 'Хотят дружить' : 'Я хочу дружить'?></div>

    <?php
        $this->widget('zii.widgets.CListView', array(
            'ajaxUpdate' => false,
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

</div>