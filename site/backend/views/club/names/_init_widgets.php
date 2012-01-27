<?php
$model = new NameSaintDate();
$this->widget('DeleteWidget', array(
    'init' => true,
    'modelName' => get_class($model),
    'modelAccusativeName' => $model->accusativeName,
    'selector'=>'div.list'
));
$model = new NameFamous();
$this->widget('DeleteWidget', array(
    'init' => true,
    'modelName' => get_class($model),
    'modelAccusativeName' => $model->accusativeName,
    'selector'=>'div.famous_block'
));
$model = new NameMiddle();
$this->widget('EditDeleteWidget', array(
    'model' => $model,
    'attribute' => 'value',
    'options'=> array(
        'edit_selector'=>'p.title',
        'ondelete'=>'$(this).parent().remove();'
    )
));
?>