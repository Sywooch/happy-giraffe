<h1>Популярное</h1>

<h3>В клубах</h3>
<ul>
    <?php foreach ($communityContents as $i => $c): ?>
        <li><?=++$i?>. <?=$c->title?> - <?=Rating::model()->countByEntity($c)?></li>
    <?php endforeach; ?>
</ul>

<h3>В блогах</h3>
<ul>
    <?php foreach ($blogContents as $i => $c): ?>
    <li><?=++$i?>. <?=$c->title?> - <?=Rating::model()->countByEntity($c)?></li>
    <?php endforeach; ?>
</ul>