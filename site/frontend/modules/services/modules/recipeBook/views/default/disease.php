<?php $this->renderPartial('_left_col', array(
    'cat_diseases' => $cat_diseases,
    'active_disease' => $model
));

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/disease.js', CClientScript::POS_HEAD);

?>
<div class="right-inner">

    <?php $this->renderPartial('disease_data', array(
        'recipes' => $recipes,
        'pages' => $pages
    )); ?>

    <div class="clear"></div>
</div>