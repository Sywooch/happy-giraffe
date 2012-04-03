<div class="user-cols clearfix">

    <div class="col-1">

        <div class="side-filter">
            <?php $this->renderPartial('_friends_sidebar'); ?>
        </div>

    </div>

    <div class="col-23 clearfix">

        <div class="content-title">Друзья</div>

        <?php
            $this->widget('zii.widgets.CListView', array(
                'ajaxUpdate' => false,
                'dataProvider' => $dataProvider,
                'itemView' => '_friend',
                //'summaryText' => 'Показано: {start}-{end} из {count}',
                'template' =>
                '
                    <div class="friends clearfix">
                        <ul>
                            {items}
                        </ul>
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

    </div>

</div>