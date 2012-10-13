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

<div class="gallery-photos-new cols-4 clearfix">

    <?php
        $this->widget('MyListView', array(
            'dataProvider' => $works,
            'itemView' => '_work',
            'summaryText' => 'показано: {start} - {end} из {count}',
            'pager' => array(
                'class' => 'AlbumLinkPager',
            ),
            'id' => 'photosList',
            'itemsTagName' => 'ul',
            //'template' => '{items}<div class="pagination pagination-center clearfix">{pager}</div>',
            'template' => '{items}',
            'viewData' => array(
                'currentPage' => $works->pagination->currentPage,
            ),
            'emptyText'=>'В этом альбоме у вас нет фотографий'
        ));

        $this->widget('PhotosAjaxMasonry', array(
                'dataProvider' => $works,

                'gallerySelector' => '.img > a',
                'galleryEntity' => 'Album',
                'galleryEntity_id' => $contest->id,

                'masonryContainerSelector' => '#photosList ul.items',
                'masonryItemSelector' => 'li',
                'masonryColumnWidth' => 240
            )
        );
    ?>

</div>