<h1>Хотят общаться</h1>

<ul>
    <?php foreach ($users as $i => $u): ?>
        <li><?=++$i?>. <?=$u->fullName?></li>
    <?php endforeach; ?>
</ul>

<?php $this->render('_chatButton'); ?>



