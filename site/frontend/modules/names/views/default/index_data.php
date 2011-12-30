<div class="handbook_names_alfa">
<?php if ($pages !== null): ?>
<ul>
        <? $i=0;
            foreach($names as $name): ?>
            <li><? $this->renderPartial('_name', array('data' => $name)); ?></li>
            <?php $i++; ?>
            <?php if ($i%10 == 0 && $i != 30) echo '</ul><ul>' ?>
        <? endforeach; ?>
</ul>
<?php else: ?>
<?php $col = ceil(count($names)/3) ?>
<ul>
            <? $i=0;
            foreach($names as $name): ?>
                <li><? $this->renderPartial('_name', array('data' => $name)); ?></li>
                <?php $i++; ?>
                <?php if ($i%$col == 0 && $i != $col*3) echo '</ul><ul>' ?>
                <? endforeach; ?>
</ul>
<?php endif; ?>
</div>

<?php if ($pages !== null): ?>
    <?php if ($pages->pageCount > 1): ?>
    <div class="pagination pagination-center clearfix">
                <span class="text">
                    Показано: <?php echo $pages->currentPage * $pages->pageSize + 1; ?>-<?php echo ($pages->currentPage + 1) * $pages->pageSize; ?> из <?php echo $pages->itemCount; ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Страницы:
                </span>
        <?php $this->widget('LinkPager', array(
        'pages' => $pages,
    )); ?>
    </div>
    <?php endif; ?>
<?php endif; ?>