<?php
/**
 * @var Page $page
 * @var int $selected_phrase_id
 * @var int $period
 */

$goodPhrases = $page->goodPhrases();
Yii::app()->clientScript->registerScript('set_phrase', 'SeoLinking.phrase_id = "' . $selected_phrase_id . '"');
?>

<div class="seo-table table-result table-promotion">

    <div class="center-title">
        <big><?=$page->getArticleTitle() ?></big>
        <a href="<?=$page->url ?>" target="_blank"><?=$page->url ?></a>
    </div>

    <div class="fast-filter">
        <span>Период</span>
        &nbsp;&nbsp;
        <a href="javascript:;" class="active" onclick="SeoLinking.loadStats(this, 1, <?=$page->id ?>);">Неделя</a>
        |
        <a href="javascript:;" onclick="SeoLinking.loadStats(this, 2, <?=$page->id ?>)">Месяц</a>
    </div>

    <div class="table-box table-promotion-links" style="width:720px;margin:0 auto 40px;">
        <table>
            <thead>
            <tr>
                <th rowspan="2" class="col-1">Ключевое слово иили фраза</th>
                <th colspan="2"><i class="icon-yandex"></i></th>
                <th colspan="2"><i class="icon-google"></i></th>
                <th rowspan="2">Общие визиты</th>
                <th rowspan="2">Ссылок</th>
            </tr>
            <tr>
                <th>Позиции</th>
                <th>Визиты</th>
                <th>Позиции</th>
                <th>Визиты</th>
            </tr>
            </thead>
            <tbody>
            <?php $this->renderPartial('_stats',compact('period', 'goodPhrases', 'selected_phrase_id', 'page')); ?>
            </tbody>
        </table>
    </div>
</div>

<div class="promotion-links clearfix" id="result" style="min-height: 200px;">

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
            <?php foreach ($page->inputLinks as $input_link): ?>
                <?php $this->renderPartial('_link_info', array('input_link' => $input_link)) ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?php if ($selected_phrase_id !== null): ?>
<script type="text/javascript">
    $(function () {
        $('#result').addClass('loading-block');
        $.post('/promotion/linking/phraseInfo/', {phrase_id:<?=$selected_phrase_id ?>}, function (response) {
            $('#result').removeClass('loading-block');
            $('#result').html(response);
        });
    });
</script>
<?php endif ?>