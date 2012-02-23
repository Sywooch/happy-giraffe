<h1>Назначение прав пользователю #<?php echo $model->id; ?></h1>
<?php echo CHtml::link('назад', $this->createUrl('userRoles/admin', array())) ?><br><br>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>