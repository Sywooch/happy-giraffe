<?php
	$cs = Yii::app()->getClientScript();
	$js = "
$('#sort').change(function() {
	window.location.href = '" . $this->createAbsoluteUrl('/contest/' . $contest->id . '/list/') . "' + $(this).val() + '/';
});
	";
    $js2 = '
        			var $container = $(\'.gallery-photos-new\');

			$container.imagesLoaded( function(){
				$container.masonry({
					itemSelector : \'li\',
					columnWidth: 240,
					saveOptions: true,
					singleMode: false,
					resizeable: true
				});
			});
    ';

	$cs
        ->registerScript('contest_list', $js)
        ->registerScript('contest_list2', $js2)
        ->registerScriptFile('/javascripts/jquery.masonry.min.js')
    ;
?>

<?php
Yii::app()->eauth->renderWidget(array(
    'mode' => 'assets',
));
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

<?php if ($contest->id == 5): ?>
    <p style="color: #F66161;">Уважаемые участники конкурса!<br />
        В процесс определения победителей конкурса внесены изменения! Теперь победители будут определяться экспертным жюри из числа первых ста участников, набравших наибольшее количество голосов.<br />
        <br />
        С уважением,<br />
        администрация портала "Веселый Жираф"</p><br />
<?php endif; ?>

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

<div class="content-title">Участники конкурса (<?=$works->totalItemCount ?>)</div>

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


