<ul>
    <li class="new<?php if ($status == 1) echo ' active' ?>">
        <a href="<?=$this->createUrl('reports', array('status' => 1)) ?>">Новое</a>
        <span class="count"><?=SeoTask::getTaskCount(1) ?></span>
    </li>
    <li class="new correction<?php if ($status == 2) echo ' active' ?>">
        <a href="<?=$this->createUrl('reports', array('status' => 2)) ?>">Коррекция</a>
        <span class="count"><?=SeoTask::getTaskCount(2) ?></span>
    </li>
    <li class="new publish<?php if ($status == 3) echo ' active' ?>">
        <a href="<?=$this->createUrl('reports', array('status' => 3)) ?>">Публикация</a>
        <span class="count"><?=SeoTask::getTaskCount(3) ?></span>
    </li>
    <li class="new check<?php if ($status == 4) echo ' active' ?>">
        <a href="<?=$this->createUrl('reports', array('status' => 4)) ?>">Проверка</a>
        <span class="count"><?=SeoTask::getTaskCount(4) ?></span>
    </li>
    <li class="new process<?php if ($status == 5) echo ' active' ?>">
        <a href="<?=$this->createUrl('reports', array('status' => 5)) ?>">Выполненные</a>
        <span class="count"><?=SeoTask::getTaskCount(5) ?></span>
    </li>

</ul>

<style type="text/css">
    div.tab-box{display: block !important;}
</style>