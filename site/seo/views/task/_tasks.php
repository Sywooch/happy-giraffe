<?php

foreach ($tasks as $task)
    $this->renderPartial('__task',array('task'=>$task));

