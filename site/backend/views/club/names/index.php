<?php
foreach ($names as $name) {
    echo CHtml::link($name->name, $this->createUrl('club/names/edit', array('id'=>$name->id))).'<br>';
}