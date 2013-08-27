<div class="clearfix margin-r20 margin-b20 js-community-subscription" data-bind="visible: active">
    <a href="<?= $this->createUrl('/blog/default/form', array('type' => 1)) ?>" data-theme="transparent"
       class="btn-blue btn-h46 float-r fancy">Добавить в клуб</a>
</div>
<div class="col-gray">

    <?php
    $this->widget('zii.widgets.CListView', array(
        'cssFile' => false,
        'ajaxUpdate' => false,
        'dataProvider' => CommunityContent::model()->getContents($this->community->id, $rubric_id, null),
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