<div class="photo-preview-row clearfix margin-t30">
    <div class="photo-preview-row_hold2">
        <div class="photo-grid clearfix">
            <?php
            $this->widget('PhotoCollectionViewWidget', array(
                'collection' => $collection,
                'width' => 600,
                'maxHeight' => 120,
                'maxRows' => 1,
            ));
            ?>
        </div>
        <div class="photo-preview-row_last">
            <div class="font-small color-gray margin-b5">смотреть <br> все фото</div>
            <a href="javascript:void(0)" class="photo-preview-row_a" onclick="PhotoCollectionViewWidget.open(<?=CJavaScript::encode(get_class($collection))?>, <?=CJavaScript::encode($collection->options)?>, <?=CJavaScript::encode($collection->photoIds[0])?>)"><?=$collection->count?></a>
        </div>
    </div>
</div>