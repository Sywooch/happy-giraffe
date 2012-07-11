<?php
/**
 * @var $pages Page[]
 */
foreach ($pages as $page): ?>
<li id="page-from-<?=$page->id ?>" onclick="SeoLinking.selectPage(this, <?=$page->id ?>)">
    <div class="col-1"><a target="_blank" href="<?=$page->url ?>" class="icon-article" style="margin-left: 0!important;"></a>&nbsp;<a href="javascript:;"><?= $page->getArticleTitle() ?></a></div>
    <div class="col-2"><?=$page->outputLinksCount ?></div>
</li>
<?php endforeach; ?>