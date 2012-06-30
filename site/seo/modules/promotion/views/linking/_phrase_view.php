<?php
/**
 * @var $pages Page[]
 * @var $keywords Keyword[]
 */
?>
<div class="step step-1">

    <div class="block-title">1 шаг</div>

    <div class="list">

        <div class="list-title">
            <div class="col-1">Выберите откуда ставить ссылку</div>
            <div class="col-2">Ссылок в блоке</div>
        </div>

        <ul>
            <?php foreach ($pages as $page): ?>
            <li id="page-from-<?=$page->id ?>" onclick="SeoLinking.selectPage(this, <?=$page->id ?>)">
                <div class="col-1"><a target="_blank" href="<?=$page->url ?>" class="icon-article" style="margin-left: 0!important;"></a>&nbsp;<a href="javascript:;"><?= $page->getArticleTitle() ?></a></div>
                <div class="col-2"><?=$page->outputLinksCount ?></div>
            </li>
            <?php endforeach; ?>
        </ul>

    </div>

</div>

<div class="step step-2">

    <div class="block-title">2 шаг</div>

    <div class="list">

        <div class="list-title">
            Выберите анкор для ссылки
        </div>

        <ul>
            <?php foreach ($keywords as $keyword): ?>
            <li onclick="SeoLinking.selectKeyword(this, <?=$keyword->id ?>)"><?=$keyword->name ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="input">
        <div class="input-title">Или введите свой</div>
        <input type="text" id="own-keyword">
    </div>

</div>

<div class="btn">

    <a href="javascript:;" class="btn-green" onclick="SeoLinking.AddLink();">Поставить ссылку</a>

</div>