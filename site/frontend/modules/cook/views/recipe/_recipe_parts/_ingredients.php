<?php if ($recipe->ingredients): ?>
<h2>Ингредиенты</h2>

<ul class="ingredients">
    <?php foreach ($recipe->ingredients as $i): ?>
    <li class="ingredient">
        <span class="name"><?=$i->ingredient->title?></span>
        - <span class="amount">
        <?php if ($i->unit->type != 'undefined'): ?><?=$i->display_value?><?php endif; ?>&nbsp;
        <?=$i->noun?></span>
    </li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>