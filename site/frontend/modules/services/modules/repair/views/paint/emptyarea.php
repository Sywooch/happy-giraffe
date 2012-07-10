<?php foreach ($areas as $key => $area) { ?>
<li>
    <?=$area['title']?>
    <?=$area['height']?> х <?=$area['width']?>
    -- <?=$area['qty']?> шт.
    <a title="Убрать" href="<?php echo CHtml::normalizeUrl(array('paint/removearea', 'id' => $key)); ?>" class="remove tooltip"
       onclick="Paint.AreaDelete($(this).attr('href')); event.preventDefault();">
    </a>
</li>
<? } ?>