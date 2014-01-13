<?php
$this->widget('zii.widgets.CMenu', array(
    'items' => array(
        array('label' => 'Прямой эфир', 'url' => array('index')),
        array('label' => 'ТОП50', 'url' => array('index', 'type' => AntispamController::TYPE_TOP50)),
        array('label' => 'От старых пользователей', 'url' => array('index', 'type' => AntispamController::TYPE_OLDUSERS)),
    ),
));
?>

