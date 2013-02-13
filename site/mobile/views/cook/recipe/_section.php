<?php
/*
 * @var $data CookRecipe
 */
?>

<div class="margin-b10">
    <?=CHtml::link($data->typeString, array('index', 'type' => $data->type, 'section' => $this->section), array('class' => 'text-small'))?>
</div>