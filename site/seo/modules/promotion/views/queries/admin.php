<?php
/* @var $this Controller
 * @var $models Page[]
 * @var $pages CPagination
 */
?>

<div class="seo-table table-result table-promotion">

    <div class="fast-filter">
        <span>Период</span>
        &nbsp;&nbsp;
        <a onclick="$('#period').val(1);$('#page-form').submit();return false;" href="#"<?php if ($period==1) echo ' class="active"'?>>Неделя</a>
        |
        <a onclick="$('#period').val(2);$('#page-form').submit();return false;" href="#"<?php if ($period==2) echo ' class="active"'?>>Месяц</a>

        <span><?= $this->getDates($period) ?></span>
        <span style="padding-left: 100px;">

            &nbsp;&nbsp;
        <a onclick="$('#mode').val(1);$('#page-form').submit();return false;" href="#"<?php if ($mode==1) echo ' class="active"'?>>ВЧ > 20</a>
        |
        <a onclick="$('#mode').val(2);$('#page-form').submit();return false;" href="#"<?php if ($mode==2) echo ' class="active"'?>>ВЧ > 10</a>
            |
        <a onclick="$('#mode').val(3);$('#page-form').submit();return false;" href="#"<?php if ($mode==3) echo ' class="active"'?>>CЧ > 20</a>
            |
        <a onclick="$('#mode').val(4);$('#page-form').submit();return false;" href="#"<?php if ($mode==4) echo ' class="active"'?>>CЧ > 10</a>

        <?php if (!empty($mode)):?>
                |
            <a onclick="$('#mode').val('');$('#page-form').submit();return false;" href="#">очистить</a>
        <?php endif ?>

        </span>
    </div>
    <form action="/promotion/queries/admin/" id="page-form">
        <input type="hidden" name="period" id="period" value="<?=$period ?>">
        <input type="hidden" name="mode" id="mode">
    </form>

    <div class="table-box">
        <table>
            <thead>
            <tr>
                <th rowspan="2" class="col-1">Название статьи, ссылка</th>
                <th rowspan="2" class="col-1">Ключевые слова и фразы</th>
                <th colspan="3"><i class="icon-yandex"></i></th>
                <th colspan="2"><i class="icon-google"></i></th>
                <th rowspan="2">Общие визиты</th>
                <th rowspan="2">Sape</th>
                <th rowspan="2">Пере-<br>линковка</th>
            </tr>
            <tr>
                <th><a href="javascript:;">Частота</a></th>
                <th><a href="?period=<?=$period ?>&sort=yandex_pos">Позиции</a></th>
                <th><a href="?period=<?=$period ?>&sort=yandex_visits">Визиты</a></th>
                <th><a href="?period=<?=$period ?>&sort=google_pos">Позиции</a></th>
                <th><a href="?period=<?=$period ?>&sort=google_visits">Визиты</a></th>
            </tr>
            </thead>
            <tbody>

            <?php PromotionHelper::model()->loadPositions($models) ?>
            <?php foreach ($models as $model): ?>
                <?php $goodPhrases = $model->goodPhrases($period); ?>
                <tr id="key-<?=$model->id ?>">
                    <td rowspan="<?=count($goodPhrases) > 1 ? count($goodPhrases) + 1 : 1 ?>" class="col-1 row-col">
                        <?=$model->getArticleLink() ?>
                    </td>


                <?php if (count($goodPhrases) > 1):?>
                    <td><b>Все ключевые слова и фразы</b></td>
                    <td>-</td>
                    <td>-</td>
                    <td><b><?=$visits1 = $model->getVisits(2, $period) ?></b></td>
                    <td>-</td>
                    <td><b><?=$visits2 = $model->getVisits(3, $period) ?></b></td>
                    <td><b><?=($visits1+$visits2) ?></b></td>
                    <td></td>
                    </tr><tr>
                <?php endif ?>

                <?php foreach ($goodPhrases as $phrase): ?>
                    <td><?=$phrase->keyword->name ?></td>
                    <td><?=$phrase->keyword->wordstat ?></td>
                    <td style="width: 60px;"><?=PromotionHelper::model()->getPositionView($phrase->id, 2) ?></td>
                    <td><?=$visits1 = $phrase->getVisits(2, $period) ?></td>
                    <td style="width: 60px;"><?=PromotionHelper::model()->getPositionView($phrase->id, 3) ?></td>
                    <td><?=$visits2 =$phrase->getVisits(3, $period) ?></td>
                    <td><?=($visits1+$visits2) ?></td>
                    <td><a href="javascript:;" class="icon-plus"></a></td><?php
                    $url = $this->createUrl('/promotion/linking/view', array('id'=>$phrase->page_id, 'selected_phrase_id'=>$phrase->id));
                    ?>
                    <td><b><a onmouseover="SeoLinking.showDonors(this, <?=$phrase->id ?>)" target="_blank" href="<?=$url ?>"><?=PromotionHelper::model()->getInnerLinksCount($phrase->id) ?></a></b><a target="_blank" href="<?=$url ?>" class="icon-arr-r"></a></td>
                </tr><tr>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>

            </tbody>

        </table>
    </div>

    <?php if ($pages->pageCount > 1): ?>
    <div class="pagination pagination-center clearfix">
        <?php $this->widget('MyLinkPager', array(
        'header' => false,
        'pages' => $pages,
    )); ?>
    </div>
    <?php endif; ?>

</div>
<div id="donors">

</div>
<div id="positions">

</div>
