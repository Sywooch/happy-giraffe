<?php
/*
 * @var $data CommunityContent
 * @var $full boolean
 */

$mobileCommunity = $data->rubric->community->mobileCommunity;
?>

<div class="entry">
    <div class="margin-b10">
        <?=CHtml::link($mobileCommunity->title, $mobileCommunity->url, array('class' => 'text-small'))?>
    </div>
    <?php $this->renderPartial('/_entry_header', array('data' => $data, 'full' => $full)); ?>
    <div class="entry-content wysiwyg-content clearfix">
        <?=($full) ? $data->content->purified->text : $data->purified->preview?>
        <?php if ($data->type_id == CommunityContent::TYPE_VIDEO): ?>
            <?=$data->video->getEmbed()?>
        <?php endif; ?>
    </div>


</div>