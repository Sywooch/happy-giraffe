<?php
	$cs = Yii::app()->getClientScript();
	$js = "
$('#sort').change(function() {
	window.location.href = '" . $this->createAbsoluteUrl('/contest/' . $contest->id . '/list/') . "' + $(this).val() + '/';
});
	";
	$cs->registerScript('contest_list', $js);
?>

<?php
$this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
    'selector' => '.img > a',
    'entity' => 'Contest',
    'entity_id' => $contest->id,
    'entity_url' => $contest->getUrl(),
    'query' => array('sort' => $sort),
));
?>

<div class="a-right fast-sort">
    Сортировать по:
    <?php echo CHtml::dropDownList('sort', $sort,
    array(
        'created' => 'Дате',
        'rate' => 'Рейтингу',
    ),
    array(
        'id' => 'sort',
        'class' => 'chzn'
    )); ?>
</div>

<div class="content-title">Участники конкурса</div>



<?php
    $this->widget('zii.widgets.CListView', array(
        'ajaxUpdate' => false,
        'dataProvider' => $works,
        'itemView' => '_work',
        'itemsTagName' => 'ul',
        'summaryText' => 'Показано: {start}-{end} из {count}',
        'pager' => array(
            'class' => 'AlbumLinkPager',
        ),
        'template' => '<div class="gallery-photos-new cols-4 clearfix">{items}</div>
            <div class="pagination pagination-center clearfix">
                {pager}
            </div>
        ',
        'viewData' => array(
            'full' => false,
        ),
    ));
?>

