<?php
/**
 * @var PhotoPostCollection $collection
 * @var AlbumPhoto $coverPhoto
 */
?>

<div id="photoPostWidget_<?=$this->post->id?>" data-bind="visible: true" style="display: none;">
    <!-- ko if: state() == 0 -->
    <div class="photo-grid clearfix">
        <div class="photo-grid_row clearfix">
            <!-- Ловить клик на photo-grid_i для показа увеличенного фото -->
            <div class="photo-grid_i" onclick="PhotoCollectionViewWidget.open(<?=CJavaScript::encode(get_class($collection))?>, <?=CJavaScript::encode($collection->options)?>)">
                <?=CHtml::image($coverPhoto->getPreviewUrl('580', null, Image::WIDTH), $this->post->title)?>
                <div class="photo-grid_tip"><?=$collection->count?> фото</div>
                <span class="ico-play-big"></span>
            </div>
        </div>
    </div>
    <!-- /ko -->

    <!-- ko if: state() == 1 -->
    <?php
    $this->widget('PhotoCollectionViewWidget', array(
        'collection' => $collection,
        'width' => 580,
    ));
    ?>
    <!-- /ko -->


    <div class="margin-20 clearfix">
        <a href="javascript:void(0)" class="float-r btn-blue-light btn-medium" onclick="PhotoCollectionViewWidget.open(<?=CJavaScript::encode(get_class($collection))?>, <?=CJavaScript::encode($collection->options)?>)">Смотреть галерею</a>
        <?php if ($this->full): ?>
            <div class="float-l">
                <a class="b-article_photo-control b-article_photo-control__single powertip" data-bind="css: { active : state() == 0 }, click: function() {setState(0)}"></a>
                <a class="b-article_photo-control b-article_photo-control__grid powertip" data-bind="css: { active : state() == 1 }, click: function() {setState(1)}"></a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php
$js = <<<JS
    ko.applyBindings(new PhotoPostWidget(), document.getElementById('photoPostWidget_{$this->post->id}'));
JS;
$cs = Yii::app()->clientScript;
if ($cs->useAMD)
    $cs->registerAMD('PhotoPostWidget#' . $this->id, array('$' => 'jquery', 'ko' => 'knockout', 'ko_post' => 'ko_post'), $js);
else
    echo "<script type='text/javascript'>\n\t" . $js . "\n</script>";
?>