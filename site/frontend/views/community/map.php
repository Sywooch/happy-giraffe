<ul style="list-style-type: none;">
    <?php foreach ($contents as $c): ?>
        <li><?=CHtml::link($c->title, $c->url)?></li>
    <?php endforeach; ?>
</ul>