<h1>Не заполнены имена:</h1>
<ul>
    <?php foreach ($names as $name): ?>
        <li><?=$name->name ?> - <a href="<?php echo $this->createUrl('club/names/update', array('id' => $name->id)) ?>">перейти</a></li>
    <?php endforeach; ?>

</ul>