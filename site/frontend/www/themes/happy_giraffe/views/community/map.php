<ul style="list-style-type: none;">
    <?php foreach ($contents as $c): ?>
        <li><?=CHtml::link($c->name, $c->url)?></li>
    <?php endforeach; ?>
</ul>