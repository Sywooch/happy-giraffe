<div class="heading-title margin-b10 margin-t15 clearfix">
    <?=CookRecipe::model()->getTypeString($type) ?>
</div>
<!--<p class="margin-l20 margin-r40 color-gray-dark">Одним из основных свидетельств правильного течения  беременности является набор веса согласно принятым нормам. </p>-->

<?php
$this->widget('zii.widgets.CListView', array(
    'cssFile' => false,
    'ajaxUpdate' => false,
    'dataProvider' => $dp,
    'itemView' => '_recipe',
    'pager' => array(
        'class' => 'HLinkPager',
    ),
    'template' => '{items}
        <div class="yiipagination">
            {pager}
        </div>
    ',
));
?>