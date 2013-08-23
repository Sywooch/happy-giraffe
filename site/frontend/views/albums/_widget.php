<?php
/**
 * @var AlbumPhoto $model
 * @var bool $edit редактирование
 * @var bool $comments комментарии
 */
if (!isset($edit))
    $edit = false;
if (!isset($comments))
    $comments = false;

$add = empty($model->title) ? '' : ' title="'.$model->title.'" alt="'.$model->title.'"';

if (!$edit):
?><!-- widget: { entity : 'AlbumPhoto', entity_id : '<?php echo $model->id ?>' } --><?php
endif;
if ($comments):?>
    <a href="javascript:;"><img src="<?php echo $model->getPreviewUrl(165, 1000) ?>"></a>
<?php else:?>
<?php if ($model->width >= 580):
    ?><div class="b-article_in-img"><img src="<?php echo $model->getPreviewUrl(580, 1000) ?>" class="content-img"<?php echo $add ?>></div><?php
else:
    ?><div class="clearfix"><img src="<?php echo $model->getPreviewUrl(540, 1000) ?>" class="content-img"<?php echo $add ?>></div><?php
endif;
    endif;

if (!$edit):
?><!-- /widget --><?php
endif;