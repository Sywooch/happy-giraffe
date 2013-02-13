<?php
/*
 * @var $data CommunityContent
 * @var $full boolean
 */
?>

<div class="entry">
    <?php if ($data->isFromBlog || $data->rubric->community->mobileCommunity !== null): ?>
        <?php
            if ($data->isFromBlog) {
                $sectionTitle = 'Личный блог';
                $sectionUrl = $this->createUrl('user', array('user_id' => $this->author_id));
            } else {
                $sectionTitle = $data->rubric->community->mobileCommunity->title;
                $sectionUrl = $data->rubric->community->mobileCommunity->url;
            }
        ?>
        <div class="margin-b10">
            <?=CHtml::link($sectionTitle, $sectionUrl, array('class' => 'text-small'))?>
        </div>
    <?php endif; ?>
    <?php $this->renderPartial('/_entry_header', array('data' => $data, 'full' => $full)); ?>
    <div class="entry-content wysiwyg-content clearfix">
        <?=($full) ? $data->content->purified->text : $data->purified->preview?>
        <?php if ($data->type_id == CommunityContent::TYPE_VIDEO): ?>
            <?=$data->video->getEmbed()?>
        <?php endif; ?>
    </div>


</div>