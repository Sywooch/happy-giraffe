<?php
/**
 * @var AlbumPhoto $model
 */
$add = '';
if (isset($title))
    $add = ' title="'.$title.'"';
if (isset($alt))
    $add = ' alt="'.$alt.'"';

?><!-- widget: { entity : 'AlbumPhoto', entity_id : '<?php echo $model->id ?>' } --><?php
if ($model->width >= 580):
    ?><div class="b-article_in-img"><img src="<?php echo $model->getPreviewUrl(580, 1000) ?>" class="content-img"<?php echo $add ?>></div><?php
else:
    ?><div class="clearfix"><img src="<?php echo $model->getPreviewUrl(540, 1000) ?>" class="content-img"<?php echo $add ?>></div><?php
endif; ?><!-- /widget -->