<?php
/* @var $this SController
 * @var $phrase PagesSearchPhrase
 */
$period = 2;
?>
<div class="seo-table table-result table-promotion">

    <div class="center-title">
        <big><?=$page->getArticleTitle() ?></big>
        <a href="<?=$page->url ?>" target="_blank"><?=$page->url ?></a>
    </div>

    <div class="table-box table-promotion-links">

        <div class="table-inline-title"><?=$phrase->keyword->name ?></div>

        <table style="width:550px;">
            <thead>
            <tr>
                <th colspan="3"><i class="icon-yandex"></i></th>
                <th colspan="2"><i class="icon-google"></i></th>
                <th rowspan="2">Общие визиты</th>
                <th rowspan="2">Ссылок</th>
            </tr>
            <tr>
                <th>Частота</th>
                <th>Позиции</th>
                <th>Визиты</th>
                <th>Позиции</th>
                <th>Визиты</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?=$phrase->keyword->getFrequency() ?></td>
                <td><?=$phrase->getPosition(2) ?></td>
                <td><?=$visits1 = $phrase->getVisits(2, $period) ?></td>
                <td><?=$phrase->getPosition(3) ?></td>
                <td><?=$visits2 = $phrase->getVisits(3, $period) ?></td>
                <td><?=($visits1 + $visits2) ?><span class="sup"><?=$phrase->getAverageVisits() ?></span></td>
                <td><b><a><?=$phrase->linksCount ?></a></b></td>
            </tr>

            </tbody>

        </table>
    </div>

</div>

<div class="promotion-links clearfix">

    <?php $this->renderPartial('__steps', compact('phrase', 'pages', 'keywords')); ?>

    <div class="btn">

        <a href="javascript:;" class="btn-green" onclick="SeoLinking.AddLinkAuto()">Поставить ссылку</a>
        <br>
        <a href="javascript:;" onclick="SeoLinking.skip()" class="skip">Пропустить</a>

    </div>

</div>

<div class="seo-table table-result" id="page-links">

    <div class="table-box">
        <table>
            <thead>
            <tr>
                <th class="col-1">Ключевые слова или фразы</th>
                <th class="col-1">Со статьи</th>
                <th>Когда<br>поставлена</th>
                <th>Анкор</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($phrase->links as $input_link): ?>
                <?php $this->renderPartial('_link_info', array('input_link' => $input_link)) ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>