<!--<div class="heading-title margin-b10 margin-t15 clearfix">
    <?=CookRecipe::model()->getTypeString($type) ?>
</div>-->
<div class="b-main_col-hold clearfix">
    <?php
    $this->widget('LiteListView', array(
        'dataProvider' => $dp,
        'itemView' => '_recipe',
        'tagName' => 'div',
        'htmlOptions' => array(
            'class' => 'b-main_col-article'
        ),
        'itemsTagName' => 'div',
        'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
    ));
    ?>
    <aside class="b-main_col-sidebar visible-md"></aside>
</div>
