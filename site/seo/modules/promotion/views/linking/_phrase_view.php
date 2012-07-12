<?php
/**
 * @var $pages Page[]
 * @var $keywords Keyword[]
 * @var $phrase PagesSearchPhrase
 */
?>
<div class="step step-1">

    <div class="block-title">1 шаг</div>

    <div class="list">

        <div class="list-title">
            <div class="col-1">Выберите откуда ставить ссылку</div>
            <div class="col-2">Ссылок в блоке</div>
        </div>

        <ul id="similar-pages">
            <?php $this->renderPartial('_pages', compact('pages')); ?>
        </ul>

    </div>
    <div class="input">
        <div class="input-title">Или введите запрос</div>
        <input type="text" id="own-query">
        <a href="javascript:;" class="btn-green-small" onclick="SeoLinking.similarPages($(this).prev().val(), <?=$phrase->id ?>)">Ok</a>
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