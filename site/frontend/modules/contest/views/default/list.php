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

<?php if ($contest->id == 4): ?>
    <p style="color: #F66161;">Уважаемые участники конкурса «Веселые брызги»!<br />
    В связи с массовой накруткой голосов и поступлением жалоб, администрацией портала «Веселый Жираф» было принято решение изменить систему выбора победителей. Победителей конкурса выберет администрация сайта, руководствуясь следующими требованиями: качество конкурсной фотографии и максимальное соответствие тематике конкурса.<br />
    Результаты конкурса будут объявлены 7.12.2012<br />
    С уважением, администрация портала «Веселый Жираф»</p>
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


