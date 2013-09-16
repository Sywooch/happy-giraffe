<?php if ($this->href === null): ?>
<div class="photo-grid clearfix">
    <?php foreach ($grid as $row): ?>
    <div class="photo-grid_row clearfix" >
        <?php foreach ($row['photos'] as $p): ?>
        <div class="photo-grid_i" onclick="PhotoCollectionViewWidget.open(<?=CJavaScript::encode(get_class($this->collection))?>, <?=CJavaScript::encode($this->collection->options)?>, <?=CJavaScript::encode($p->id)?><?php if ($this->windowOptions !== null): ?>, <?=CJavaScript::encode($this->windowOptions)?><?php endif; ?>)">
            <?=CHtml::image($p->getPreviewUrl(null, $row['height'], Image::HEIGHT), '', array('class' => 'photo-grid_img'))?>
            <div class="photo-grid_overlay">
                <span class="photo-grid_zoom"></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="photo-grid clearfix">
    <?php foreach ($grid as $row): ?>
        <div class="photo-grid_row clearfix" >
            <?php foreach ($row['photos'] as $p): ?>
                <div class="photo-grid_i">
                    <a href="<?=$this->href?>">
                        <?=CHtml::image($p->getPreviewUrl(null, $row['height'], Image::HEIGHT), '', array('class' => 'photo-grid_img'))?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>