<?php
    $services = array();
    foreach ($action->data as $service)
        $services[] = $service['service'];
?>

<div class="box fast-teasers-box fast-teasers clearfix list-item">

    <div class="box-title"><?=($users[$action->user_id]->gender == 1) ? 'Применил' : 'Применила'?> сервисы</div>

    <ul>
        <?php foreach ($services as $s): ?>
            <li>
                <?php $this->renderPartial('activity/services/' . $s); ?>'
            </li>
        <?php endforeach; ?>
    </ul>

</div>