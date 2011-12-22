<?php
foreach ($data as $model)
    echo CHtml::link($model['name'], $this->createUrl('/names/default/name', array('name' => $model['name'])));?><br>