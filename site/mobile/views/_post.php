<?php
/*
 * @var $data CommunityContent
 * @var $full boolean
 */
?>

<div class="entry">
    <?php $this->renderPartial('/_section', array('data' => $data)); ?>
    <?php $this->renderPartial('/_entry_header', array('data' => $data, 'full' => $full)); ?>
    <div class="entry-content wysiwyg-content clearfix">
        <?=($full) ? $data->content->purified->text : $data->purified->preview?>
        <?php if ($data->type_id == CommunityContent::TYPE_VIDEO): ?>
            <div class="video-fluid">
                <?=$data->video->getEmbed()?>
            </div>
        <?php endif; ?>
    </div>


</div>