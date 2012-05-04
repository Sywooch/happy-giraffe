<?php
/* @var $this Controller
 * @var $tasks SeoTask[]
 */
?>
<ul>
    <?php foreach ($tasks as $task): ?>
    <li id="task-<?=$task->id ?>"><?=$task->text ?>
        <a href="javascript:void(0);" onclick="SeoModule.toEditor(this);">to journalist</a>
        <a href="javascript:void(0);" onclick="SeoModule.toModer(this);">to moderator</a>
    </li>
    <?php endforeach; ?>
</ul>