<?php
	$cs = Yii::app()->getClientScript();
	$js = "
$('#sort').change(function() {
	window.location.href = '" . $this->createAbsoluteUrl('/contest/' . $contest->id . '/list/') . "' + $(this).val() + '/';
});
	";
	$cs->registerScript('contest_list', $js);
?>

<div id="gallery">
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

    <div class="gallery-photos clearfix">
        <ul>
            <?php foreach ($works as $w): ?>
            <li>
                <table>
                    <tr>
                        <td class="img"><div><?php echo CHtml::link(CHtml::image($w->photo->photo->getPreviewUrl(150, 150), $w->title), $this->createUrl('/contest/default/work', array('id' => $w->id))); ?></div></td>
                    </tr>
                    <tr class="title">
                        <td align="center"><div><?php echo $w->paredDownTitle; ?></div></td>
                    </tr>
                    <tr class="rank"><td><span><?php echo $w->rate; ?></span> баллов</td></tr>
                </table>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <?php if ($pages->pageCount > 1): ?>
    <div class="pagination pagination-center clearfix">
        <?php $this->widget('AlbumLinkPager', array(
        'pages' => $pages,
    )); ?>
    </div>
    <?php endif; ?>

</div>