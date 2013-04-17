<?php
    Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

    $this->widget('zii.widgets.CListView', array(
        'cssFile'=>false,
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
