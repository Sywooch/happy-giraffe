<?php
$this->widget('LiteListView', array(
    'dataProvider' => $dp,
    'itemView' => 'site.frontend.modules.som.modules.activity.widgets.views._view_onAir',
    'tagName' => 'div',
    'itemsTagName' => false,
    'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
));
?>