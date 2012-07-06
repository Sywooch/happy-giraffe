<?php
/* @var $this Controller
 * @var $data CommunityContent
 */
$prev = $data->getPrevPost();
$next = $data->getNextPost();

?><div class="entry-nav clearfix">
    <?php if (!empty($prev)):?>
        <div class="next">
            <span>Следуюшая статья</span>
            <?=HHtml::link(CHtml::encode($next->title), $next->url) ?>
        </div>
    <?php endif ?>
    <?php if (!empty($next)):?>
    <div class="prev">
        <span>Предыдущая статья</span>
        <?=HHtml::link(CHtml::encode($prev->title), $prev->url) ?>
    </div>
    <?php endif ?>
</div>