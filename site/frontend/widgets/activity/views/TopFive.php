<h1>5 самых-самых</h1>

<h3>Авторы</h3>
<ul>
    <?php foreach ($topAuthors as $i => $u): ?>
        <li><?=++$i?>. <?=$u->fullName?> - <?=$u->authorsRate?></li>
    <?php endforeach; ?>
</ul>

<h3>Комментаторы</h3>
<ul>
    <?php foreach ($topCommentators as $i => $u): ?>
        <li><?=++$i?>. <?=$u->fullName?> - <?=$u->commentatorsRate?></li>
    <?php endforeach; ?>
</ul>

