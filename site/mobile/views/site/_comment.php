<?php
/*
 * $data Comment
 */
?>

<div class="comments_i">
    <div class="comments_meta clearfix">
        <span class="comments_time"><?=HDate::GetFormattedTime($data->created, ', ')?></span>
        <span class="comments_num"><?=$data->position?></span>
        <?php $this->widget('AvatarWidget', array('user' => $data->author)); ?>
        <?=CHtml::link($data->author->fullName, '', array('class' => 'textdec-onhover'))?>
    </div>
    <div class="comments_ctn">
        <?php if (($data->quote_id !== null && $data->quote)): ?>
            <div class="comments_quote">
                <?=$data->quote_text != '' ? $data->quote_text : $data->quote->text; ?>
            </div>
        <?php endif; ?>
        <?=$data->purified->text?>
    </div>
</div>