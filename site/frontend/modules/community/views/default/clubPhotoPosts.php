<div class="content-cols clearfix">

    <div class="col-1">

    </div>
    <div class="col-23-middle ">
        <?php $this->widget('zii.widgets.CListView', array(
            'cssFile' => false,
            'ajaxUpdate' => false,
            'dataProvider' => $dp,
            'itemView' => 'blog.views.default.view',
            'pager' => array(
                'class' => 'HLinkPager',
            ),
            'template' => '{items}
                            <div class="yiipagination">
                                {pager}
                            </div>
                        ',
            'emptyText' => '',
            'viewData' => array('full' => false),
        ));
        ?>
    </div>

</div>