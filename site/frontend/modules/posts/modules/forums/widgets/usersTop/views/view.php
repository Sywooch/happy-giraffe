<ul>
<?php foreach ($scores as $id => $score): ?>
    <li>
        <p><?=CHtml::link($users[$id]->fullName, $users[$id]->profileUrl)?></p>
        <p><?=$score?></p>
    </li>
<?php endforeach; ?>
</ul>