<?php
/**
 * @var LiteController $this
 */
$this->beginContent('application.modules.iframe.views._parts.lite');

Yii::app()->clientScript->registerAMD('userAdd', array('common' => 'common', '$' => 'jquery'), "$('#userAdd').show();");
?>
<?=$this->clips['header-banner']?>

<?=$content?>

<?php $this->endContent(); ?>