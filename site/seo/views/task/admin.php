<?php
$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript
    ->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);

?><h1>Кейворды</h1>
<input type="checkbox" id="hide-used" <?php if (Yii::app()->user->getState('hide_used') == 1) echo 'checked="checked"' ?> onchange="SeoModule.hideUsed(this);">
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'keywords-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'ajaxUpdate'=>true,
    'rowCssClassExpression'=>'$data->getClass()',
    'columns' => array(
        'id',
        'name',
        'data',
        'yandexPopularity.value',
        array(
            'name'=>'btns',
            'value'=>'$data->getButtons()',
        ),
    ),
));
?>
<a href="<?= $this->createUrl('tasks') ?>" class="selectedLink">Выбранные (<span><?= TempKeywords::model()->count() ?></span>)</a>
<style type="text/css">
    #keywords-grid .active td{
        background: #adff2f !important;
    }
    #keywords-grid .used td{
        background: #5bbdff !important;
    }
</style>