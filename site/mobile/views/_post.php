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
                <?=$data->video->embed?>
            </div>
        <?php endif; ?>
    </div>


</div>

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- ÃÓ·ËÎ¸Ì˚È ·‡ÌÌÂ -->
<ins class="adsbygoogle"
     style="display:inline-block;width:320px;height:100px"
     data-ad-client="ca-pub-3807022659655617"
     data-ad-slot="3195546082"></ins>
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
</script>