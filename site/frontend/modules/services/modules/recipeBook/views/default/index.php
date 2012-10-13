<?php
    if (Yii::app()->request->getParam('Comment_page', 1) != 1) {
        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
    }

    $this->widget('zii.widgets.CListView', array(
        'ajaxUpdate' => false,
        'dataProvider' => $dp,
        'itemView' => '_recipe',
        'summaryText' => 'Показано: {start}-{end} из {count}',
        'pager' => array(
            'class' => 'AlbumLinkPager',
        ),
        'template' => '{items}
                    <div class="pagination pagination-center clearfix">
                        {pager}
                    </div>
                ',
    ));
