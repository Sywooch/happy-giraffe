<?php
/**
 * Author: alexk984
 * Date: 11.12.12
 */
?>
<h1 class="title-page"><i class="icon-friend-medium"></i> Новички на сайте</h1>
<div class="newuser-list">

    <?php $this->widget('MyListView', array(
    'id'=>'friends',
    'dataProvider' => $dataProvider,
    'itemView' => '_user',
    'pager' => array(
        'class' => 'AlbumLinkPager',
    ),
    'itemsTagName' => 'ul',
    'template' => '{items}<div class="pagination pagination-center clearfix">{pager}</div>',
))?>
</div>

<script type="text/javascript">
    $(function() {
        $('body').delegate('a.add-friend', 'click', function(){
            $.fn.yiiListView.update('friends');
        });
    });
</script>