<?php $this->widget('zii.widgets.CListView', array(
    'cssFile' => false,
    'ajaxUpdate' => false,
    'dataProvider' => CommunityContent::model()->getContents($this->community->id, $this->rubric_id, null),
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
