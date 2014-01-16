<?php $this->beginContent('//layouts/main'); ?>
<?php
$this->widget('zii.widgets.CMenu', array(
    'items' => array(
        array('label' => 'Прямой эфир', 'url' => array('live')),
    ),
));
?>
<?=$content?>
<?php $this->endContent(); ?>