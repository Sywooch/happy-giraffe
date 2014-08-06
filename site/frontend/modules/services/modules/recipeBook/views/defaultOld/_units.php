<a href="javascript:void(0)" class="trigger"><?=$unit->title?></a>
<ul style="display: none;">
    <?php foreach ($units as $u): ?>
        <li><a href="javascript:void(0)"><?=$u->title?></a><?=CHtml::hiddenField('unit_id', $u->id)?></li>
    <?php endforeach; ?>
</ul>