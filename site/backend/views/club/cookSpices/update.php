<h1>Редактирование <?php echo $model->title; ?></h1>

<?php


echo $this->renderPartial('_form', array('model' => $model));

//if (!$model->isNewRecord)
//$this->renderPartial('_form_categories', array('model' => $model));

?>