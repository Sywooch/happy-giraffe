<?php
/* @var $this Controller
 * @var $models Keywords[]
 */
?>
<ul>
    <?php foreach ($models as $keyword): ?>
        <li class="<?php
            if ($keyword->used()) echo 'used';
            elseif ($keyword->hasOpenedTask()) echo 'active';
            else echo 'default';
            ?>" id="key-<?=$keyword->id ?>"><?=$keyword->name ?></li>
    <?php endforeach; ?>
</ul>