<?php
/** @var $tasks ELTask[]
 */
?>
<div class="tasks-list">

    <ul>
        <li>
            <div class="task-title">Выберите форум для регистрации</div>
            <?php foreach ($tasks as $task): ?>
            <div class="task">
                <a href="<?=$task->site->url?>"><span class="hl"><?=$task->site->url?></span></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="javascript:;" class="btn-g small" onclick="ExtLinks.TakeForum(this, <?=$task->id?>)">Взять в работу</a>
            </div>
            <?php endforeach; ?>
        </li>
    </ul>

</div>