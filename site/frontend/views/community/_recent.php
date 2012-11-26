<div class="recent-topics">

    <div class="title">Последние темы</div>

    <ul>
        <?php foreach ($community->last as $c): ?>
        <li><?=CHtml::link(CHtml::encode($c->title), $c->url)?></li>
        <?php endforeach; ?>
    </ul>

</div>