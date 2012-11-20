<?php
/* @var $this Controller
 * @var $model ELSite
 */

$dataProvider = $model->search();
if (empty($dataProvider->criteria->condition))
    $dataProvider->criteria->condition = 'comments_count > 3 AND status != 2';
else
    $dataProvider->criteria->condition .= ' AND comments_count > 3 AND status != 2';
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
            'name' => 'comments_count',
            'header' => 'Лимит сообщений',
            'type' => 'raw',
            'value' => 'CHtml::textfield("comments_count", $data->comments_count, array("size"=>3)).\'&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="btn-g" onclick="ExtLinks.updateCommentLimit(\'.$data->id.\', this)">OK</a>\'',
            'filter' => false
        ),
        array(
            'name' => 'comments_count',
            'header' => 'Комментариев<br>написано',
            'value' => '$data->getCommentsCount()',
            'filter' => false
        ),
        array(
            'name' => 'buttons',
            'header' => 'Действия',
            'value' => '$data->getGreyListButtons()',
            'type' => 'raw',
            'filter' => false
        ),
    ),
)); ?>
</div>
<style type="text/css">
    input[name="ELSite[id]"] {width: 50px;}
    input[name="ELSite[url]"] {width: 250px;}
</style>