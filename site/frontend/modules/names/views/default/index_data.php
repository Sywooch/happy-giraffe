<table>
    <tr>
        <td>
        <? $i=0;
            foreach($names as $name): ?>
            <? $this->renderPartial('_name', array('data' => $name)); ?>
            <?php $i++; ?>
            <?php if ($i%10 == 0 && $i != 30) echo '</td><td>' ?>
        <? endforeach; ?>
        </td>
    </tr>
</table>

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