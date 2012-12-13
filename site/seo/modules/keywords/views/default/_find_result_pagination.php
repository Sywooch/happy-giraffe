<?php if ($pages->pageCount > 1): ?>
<div class="pagination pagination-center clearfix">
    <?php $this->widget('MyLinkPager', array(
    'header'=>false,
    'pages' => $pages,
)); ?>
</div>
<?php endif; ?>
