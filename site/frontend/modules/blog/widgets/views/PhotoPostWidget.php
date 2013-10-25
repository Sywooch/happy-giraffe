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
            <div class="photo-grid_i">
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
        <a href="" class="float-r btn-blue-light btn-medium">Смотреть галерею</a>
        <div class="float-l">
            <a class="b-article_photo-control b-article_photo-control__single powertip" data-bind="css: { active : state() == 0 }, click: function() {setState(0)}"></a>
            <a class="b-article_photo-control b-article_photo-control__grid powertip" data-bind="css: { active : state() == 1 }, click: function() {setState(1)}"></a>
        </div>
    </div>
</div>

<script type="text/javascript">
    ko.applyBindings(new PhotoPostWidget(), document.getElementById('photoPostWidget_<?=$this->post->id?>'));
</script>