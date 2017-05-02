<?php
/**
 * @var LiteController $this
 */
$this->beginContent('//layouts/lite/main');

Yii::app()->clientScript->registerAMD('userAdd', array('common' => 'common', '$' => 'jquery'), "$('#userAdd').show();");
?>
<?=$this->clips['header-banner']?>

<?=$content?>

<?php $this->endContent(); ?>
