<?php

$this->pageTitle = $model->isNewRecord ? 'Добавление записи' : 'Редактирование записи';
$this->renderPartial('/default/form', compact('model', 'slaveModel', 'json', 'club_id'));
?>
