<h1>Найти друзей</h1>

<ul>
    <?php foreach ($friends as $i => $f): ?>
        <li><?=++$i?>. <?=$f->fullName?></li>
    <?php endforeach; ?>
</ul>