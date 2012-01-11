<?php echo $name->name; ?>
<?php echo CHtml::link('Добавить знаменитость',$this->createUrl('/names/default/createFamous', array('id'=>$name->id))) ?>

