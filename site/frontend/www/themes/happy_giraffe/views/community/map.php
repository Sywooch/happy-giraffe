<ul>
    <?php foreach ($contents as $c): ?>
        <li><?=CHtml::link($c->name, $c->url)?></li>
    <?php endforeach; ?>
</ul>