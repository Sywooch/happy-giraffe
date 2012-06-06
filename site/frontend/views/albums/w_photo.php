<?php
/* @var AlbumsController $this
 * @var HActiveRecord $model
 * @var AlbumPhoto $photo
 */
$selected_index = null;
?>
<div id="photo-window-in">
    <div class="top-line">
        <div class="wrapper">
            <a href="javascript:;" class="window-close">закрыть<i class="icon"></i></a>
            <div class="count">Всего в альбоме <?php echo count($model->photoCollection); ?> фотографий</div>
        </div>
    </div>

    <div id="photo-thumbs">
        <div class="jcarousel">
            <ul>
                <?php foreach($model->photoCollection as $i => $p): ?>
                    <li>
                        <a href="javascript:;" data-id="<?php echo $p->primaryKey; ?>"><img src="" data-src="<?php echo $p->getPreviewUrl(100, 100, Image::HEIGHT); ?>" alt="" /></a>
                        <?php if($photo->id == $p->id) {$selected_index = $i;} ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <a href="javascript:;" class="prev" onclick="">предыдущая</a>
        <a href="javascript:;" class="next" onclick="">следующая</a>
    </div>
    <script type="text/javascript">
        <?php if($selected_index !== null): ?>
        $('#photo-thumbs', $('#photo-window')).bind('jcarouselinitend', function(carousel) {
            var count = $('#photo-thumbs li').size();
            var ready = 0;
            $('#photo-thumbs img', $('#photo-window')).each(function(){
                $(this).get(0).onload = function() {
                    ready++;
                    if (ready == count) {
                        $(this).parents('#photo-thumbs').find('li:eq(<?php echo $selected_index; ?>)').addClass('active');
                        $('#photo-thumbs', $('#photo-window')).jcarousel('scroll', <?php echo $selected_index; ?>);
                    }
                };
                $(this).attr('src', $(this).attr('data-src'));
            });
        });
            <?php endif; ?>
    </script>
    <div id="w-photo-content">
        <?php $this->renderPartial('w_photo_content', compact('model', 'photo', 'selected_index')); ?>
    </div>
</div>