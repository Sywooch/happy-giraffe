<?php
/*if ($left)
{
    $this->metaNavigation->prev = $left->parsedUrl;
    ?>
    <a href="<?= $left->parsedUrl ?>" class="post-arrow display-n post-arrow__l" rel="prev">
        <div class="i-photo-arrow"></div>
        <div class="post-arrow_in-hold">
            <div class="post-arrow_in">
                <div class="verticalalign-m-help"></div>
                <?php if ($left->socialObject->imageUrl): ?>
                    <div class="post-arrow_img-hold"><img src="<?= $left->socialObject->imageUrl ?>" alt="" class="post-arrow_img"></div>
                <?php endif; ?>
                <div class="post-arrow_t"><?= $left->title ?></div>
            </div>
        </div>
    </a>
    <?php
}
if ($right)
{
    $this->metaNavigation->next = $right->parsedUrl;
    ?>
    <a href="<?= $right->parsedUrl ?>" class="post-arrow display-n post-arrow__r" rel="next">
        <div class="i-photo-arrow i-photo-arrow__r"></div>
        <div class="post-arrow_in-hold">
            <div class="post-arrow_in">
                <div class="verticalalign-m-help"></div>
                <?php if ($right->socialObject->imageUrl): ?>
                    <div class="post-arrow_img-hold"><img src="<?= $right->socialObject->imageUrl ?>" alt="" class="post-arrow_img"></div>
                <?php endif; ?>
                <div class="post-arrow_t"><?= $right->title ?></div>
            </div>
        </div>
    </a>
    <?php
}*/
?>
<table class="article-nearby clearfix">
    <tr>
        <td><?= $left ? '<a href="' . $left->parsedUrl . '" class="article-nearby_a article-nearby_a__l" rel="prev"><span class="article-nearby_tx">' . $left->title . '</span></a>' : '&nbsp;' ?></td>
        <td><?= $right ? '<a href="' . $right->parsedUrl . '" class="article-nearby_a article-nearby_a__r" rel="next"><span class="article-nearby_tx">' . $right->title . '</span></a>' : '&nbsp;' ?></td>
    </tr>
</table>