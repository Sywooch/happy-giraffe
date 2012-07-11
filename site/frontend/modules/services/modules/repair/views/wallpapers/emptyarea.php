<?php foreach ($areas as $key => $area) { ?>
<li>
    <?=$area['title']?>
    <?=$area['height']?> х <?=$area['width']?>
    -- <?=$area['qty']?> шт.
    <a href="<?php echo CHtml::normalizeUrl(array('wallpapers/removearea', 'id' => $key)); ?>" class="remove tooltip" title="Убрать"
       onclick="Wallpapers.AreaDelete($(this).attr('href')); event.preventDefault();">
    </a>
</li>
<? } ?>