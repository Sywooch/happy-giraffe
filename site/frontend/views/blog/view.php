<?php $this->renderPartial('/community/_post', array('data' => $data, 'full' => true)); ?>

<?php $this->renderPartial('_prev_next', array('data' => $data)); ?>

<?php $this->widget('application.widgets.commentWidget.CommentWidget', array(
    'model' => $data,
)); ?>

<?php
$remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
$remove_tmpl->registerTemplates();
$this->endWidget();
?>