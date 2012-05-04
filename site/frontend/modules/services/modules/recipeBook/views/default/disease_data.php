<?php foreach($recipes as $recipe): ?>
    <? $this->renderPartial('_view', array('data' => $recipe)); ?>
<? endforeach; ?>

<?php if ($pages !== null): ?>
    <?php if ($pages->pageCount > 1): ?>
    <div class="pagination pagination-center clearfix">
        <?php $this->widget('AlbumLinkPager', array(
        'pages' => $pages,
    )); ?>
    </div>
    <?php endif; ?>
<?php endif; ?>