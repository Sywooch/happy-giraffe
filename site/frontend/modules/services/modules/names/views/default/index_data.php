<div class="clearfix">
<?php $i=1; foreach($names as $name): ?>
        <?php $this->renderPartial('_name', array('data' => $name,'like_ids'=>$like_ids,'num'=>$i));$i++; ?>
<?php endforeach; ?>
</div>

<?php if ($pages !== null): ?>
    <?php if ($pages->pageCount > 1): ?>
    <div class="yiipagination">
        <?php $this->widget('HLinkPager', array(
            'pages' => $pages,
        )); ?>
    </div>
    <?php endif; ?>
<?php endif; ?>