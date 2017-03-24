<?php
/**
 * @var LiteController $this
 */
$this->beginContent('application.modules.iframe.views._parts.common_menu');

Yii::app()->clientScript->registerAMD('userAdd', array('common' => 'common', '$' => 'jquery'), "$('#userAdd').show();");
?>

<?=$content?>
<?php $this->endContent(); ?>