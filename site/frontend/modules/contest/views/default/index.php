<div id="contest">

    <div class="contest-list ">
        <h1>НАШИ КОНКУРСЫ</h1>
        <?php
            $this->widget('zii.widgets.CListView', array(
                'cssFile'=>false,
                'dataProvider' => $dp,
                'itemView' => '_contest',
                'pager' => array(
                    'class' => 'AlbumLinkPager',
                ),
                'template' => '
                    {items}
                    <div class="pagination pagination-center clearfix">
                        {pager}
                    </div>
                ',
            ));
        ?>

    </div>

</div>