<?php foreach ($links as $link): ?>
    <ul>
        <li><a href="<?=$link->url ?>" target="_blank"><?=$link->url ?></a></li>
    </ul>
<?php endforeach; ?>