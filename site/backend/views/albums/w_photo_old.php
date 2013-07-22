<?php
/* @var AlbumsController $this
 * @var HActiveRecord $model
 * @var AlbumPhoto $photo
 */
$selected_index = null;
$count = count($model->photoCollection);
?>
<div id="photo-window-in">
    <div class="top-line">
        <div class="wrapper">
            <a href="javascript:;" class="window-close">закрыть<i class="icon"></i></a>
            <div class="count">Всего в альбоме <?= $count ?> <?=Str::GenerateNoun(array('фотография', 'фотографии', 'фотографий'), $count) ?></div>
        </div>
    </div>

    <div id="photo-thumbs">
        <div class="jcarousel">
            <ul>
                <?php $collection = $model->photoCollection; ?>
                <?php foreach($collection as $i => $p): ?>
                    <li>
                        <a href="#photo-<?php echo $p->id; ?>" data-id="<?php echo $p->primaryKey; ?>"><img src="" data-src="<?php echo $p->getPreviewUrl(100, 100, Image::HEIGHT); ?>" alt="" /></a>
                        <?php if($photo->id == $p->id) {$selected_index = $i;} ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <a href="javascript:;" class="prev" onclick="">предыдущая</a>
        <a href="javascript:;" class="next" onclick="">следующая</a>
    </div>
    <script type="text/javascript">
        <?php ob_start(); ?>
        <?php foreach($collection as $i => $p): ?>
            pGallery_photos[<?php echo $p->primaryKey ?>] = {
                src : '<?php echo $p->getPreviewUrl(960, 627, Image::HEIGHT, true); ?>',
                title : '<?php echo isset($p->title) && $p->title != '' ? $p->title : null ?>',
                description : <?php echo isset($p->options['description']) ? "'" . $p->options['description'] . "'" : 'null'; ?>,
                avatar : '<?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                    'user' => $p->author,
                    'size' => 'small',
                    'sendButton' => false,
                    'location' => false
                )); ?>'
            };
        <?php endforeach; ?>
        <?php
            $params = ob_get_contents();
        flush();
        ob_flush();
            echo preg_replace('/\s+/i', ' ', $params);
        ?>
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
    <div id="photo">
        <div class="img">
            <?php echo CHtml::image($photo->getPreviewUrl(960, 627, Image::HEIGHT, true), ''); ?>
            <div class="title clearfix">
                <?php if(isset($photo->title)): ?>
                    <?php if(get_class($model) == 'CookDecorationCategory' && (Yii::app()->user->checkAccess('moderator') || Yii::app()->user->checkAccess('editor') || Yii::app()->user->checkAccess('administrator') || Yii::app()->user->checkAccess('supermoderator'))): ?>
                        <div class="in">
                            <span class="title-content">
                                <span class="title-text"><?= $photo->title; ?></span>
                                <a href="javascript:;" onclick="editPhotoTitleInWindow(this);" class="edit"></a>
                            </span>
                            <span class="title-edit" style="display:none;">
                                <input type="text" value="" />
                                <button class="btn btn-green-small" onclick="return savePhotoTitleInWindow(this);"><span><span>Ok</span></span></button>
                            </span>
                        </div>
                    <?php else: ?>
                        <div class="in">
                            <span class="title-content">
                                <span class="title-text"><?= $photo->title; ?></span>
                            </span>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                'user' => $photo->author,
                'size' => 'small',
                'sendButton' => false,
                'location' => false
            )); ?>
            </div>
        </div>
        <a href="javascript:;" class="prev"><i class="icon"></i>предыдушая</a>
        <a href="javascript:;" class="next"><i class="icon"></i>следующая</a>
        <?php if(get_class($model) == 'CookDecorationCategory' && (Yii::app()->user->checkAccess('moderator') || Yii::app()->user->checkAccess('editor') || Yii::app()->user->checkAccess('administrator') || Yii::app()->user->checkAccess('supermoderator'))): ?>
            <div class="photo-comment" style="position:relative;z-index:10;">
                <span class="title-content">
                    <span class="title-text"></span>
                    <a href="javascript:;" onclick="editPhotoTitleInWindow(this);" class="edit"></a>
                </span>
                <span class="title-edit" style="display:none;">
                    <textarea></textarea>
                    <button class="btn btn-green-small" onclick="return savePhotoTitleInWindow(this);"><span><span>Ok</span></span></button>
                </span>
            </div>
        <?php else: ?>
            <div class="photo-comment" style="position:relative;z-index:10;">
                <span class="title-content">
                    <span class="title-text"><?= $photo->title; ?></span>
                </span>
            </div>
        <?php endif; ?>
    </div>
    <div id="w-photo-content">
        <?php $this->renderPartial('w_photo_content', compact('model', 'photo', 'selected_index')); ?>
    </div>
</div>