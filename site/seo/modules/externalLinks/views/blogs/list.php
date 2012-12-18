<?php
/* @var $this Controller
 * @var $model ELSite
 */

$dataProvider = $model->search();
$dataProvider->criteria->order = 'id desc';
?>
<div class="ext-links-add">
    <?php $this->renderPartial('sub_menu')?>
</div>

<div class="seo-table">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'site-grid',
    'dataProvider' => $dataProvider,
    'filter' => $model,
    'cssFile' => false,
    'template' => '<div style="text-align: right;padding: 5px 10px;">{summary}</div><div class="pagination pagination-center clearfix">{pager}</div><div class="table-box table-grey">{items}</div><div class="pagination pagination-center clearfix">{pager}</div>',
    'summaryText' => 'показано: {start} - {end} из {count}',
    'enableSorting'=>false,
    'pager' => array(
        'class' => 'MyLinkPager',
        'header' => '',
    ),
    'columns' => array(
        array(
            'name' => 'id',
            'header' => '№'
        ),
        array(
            'name' => 'url',
            'value' => 'CHtml::link($data->url, "http://".$data->url, array("target"=>"_blank"))',
            'type' => 'raw',
            'header' => 'Адрес страницы',
        ),
        array(
            'name' => 'created',
            'value' => 'Yii::app()->dateFormatter->format(\'d MMM yyyy\',strtotime($data->created))',
            'header' => 'Дата добавления',
            'filter' => false
        ),
    ),
)); ?>
</div>

<style type="text/css">
    input[name="ELSite[id]"] {width: 50px;}
    input[name="ELSite[url]"] {width: 350px;}

    .table-box.table-grey tr td:first-child+td {max-width: 500px;white-space: pre-wrap;}
</style>