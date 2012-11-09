<?php
/* @var $this Controller
 * @var $model ELSite
 */
?>
<div class="ext-links-add">
    <?php $this->renderPartial('sub_menu')?>
</div>

<div class="seo-table">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'site-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'cssFile' => false,
    'template' => '<div style="text-align: right;padding: 5px 10px;">{summary}</div><div class="pagination pagination-center clearfix">{pager}</div><div class="table-box table-grey">{items}</div><div class="pagination pagination-center clearfix">{pager}</div>',
    'summaryText' => 'показано: {start} - {end} из {count}',
    'rowCssClassExpression' => '$data->getCssClass()',
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
            'header' => 'Форум - адрес страницы',
        ),
        array(
            'name' => 'created',
            'value' => 'Yii::app()->dateFormatter->format(\'d MMM yyyy\',strtotime($data->created))',
            'header' => 'Дата добавления',
            'filter' => false
        ),
        array(
            'name' => 'comment',
            'header' => 'Комментарий',
            'value' => '$data->getComment()',
            'filter' => false
        ),
        array(
            'name' => 'buttons',
            'header' => 'Действия',
            'value' => '$data->getButtons()',
            'type' => 'raw',
            'filter' => false
        ),
    ),
)); ?>
</div>

<style type="text/css">
    input[name="ELSite[id]"] {width: 50px;}
    input[name="ELSite[url]"] {width: 350px;}

    tr.red-1 td {background: #ffdae0;}
    tr.red-2 td {background: #f4bfc5;}
    tr.red-3 td {background: #e4a3a9;}
    tr.red-4 td {background: #d88d92;}
    tr.red-5 td {background: #d78287;}
</style>
