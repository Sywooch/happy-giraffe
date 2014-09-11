<?php
/**
 * @var PrevNextWidget $this
 * @var CommunityContent $prev
 * @var CommunityContent $next
 */
?>

<table class="article-nearby clearfix" сellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <?php if ($prev !== null): ?>
            <td>
                <div class="article-nearby_hint">Предыдущая <?=$this->getNoun()?></div>
            </td>
        <?php endif; ?>
        <?php if ($next !== null): ?>
            <td class="article-nearby_r">
                <div class="article-nearby_hint">Следующая <?=$this->getNoun()?></div>
            </td>
        <?php endif; ?>
    </tr>
    <tr>
        <?php if ($prev !== null): ?>
            <td>
                <a href="<?=$prev->url?>" class="article-nearby_a clearfix">
                    <?php if (false && (($prevPhoto = $prev->getPhoto()) !== null)): ?>
                        <span class="article-nearby_img-hold"><?=CHtml::image($prevPhoto->getPreviewUrl(null, 61, Image::HEIGHT), $prev->title)?></span>
                    <?php endif; ?>
                    <span class="article-nearby_tx"><?=$prev->title?></span>
                </a>
            </td>
        <?php endif; ?>
        <?php if ($next !== null): ?>
            <td class="article-nearby_r">
                <a href="<?=$next->url?>" class="article-nearby_a clearfix">
                    <span class="article-nearby_tx"><?=$next->title?></span>
                    <?php if (false && (($nextPhoto = $next->getPhoto()) !== null)): ?>
                        <span class="article-nearby_img-hold"><?=CHtml::image($nextPhoto->getPreviewUrl(null, 61, Image::HEIGHT), $next->title)?></span>
                    <?php endif; ?>
                </a>
            </td>
        <?php endif; ?>
    </tr>
    </tbody>
</table>