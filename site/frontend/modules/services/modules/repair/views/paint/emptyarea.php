<?php foreach ($areas as $key => $area) { ?>
<li>
    <?=$area['title']?>
    <?=$area['height']?> х <?=$area['width']?>
    -- <?=$area['qty']?> шт.
    <a href="<?php echo CHtml::normalizeUrl(array('paint/removearea', 'id' => $key)); ?>" class="remove" onclick="Paint.AreaDelete($(this).attr('href')); event.preventDefault();">
        <span class="tip">Убрать</span>
    </a>
</li>
<? } ?>