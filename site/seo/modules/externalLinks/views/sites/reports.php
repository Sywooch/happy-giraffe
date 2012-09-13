<?php
/* @var $this Controller
 * @var $models ELLink[]
 */
?>
<div class="ext-links-add">

    <div class="nav clearfix">
        <?php

        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array(
                    'label' => 'Добавить',
                    'url' => array('/externalLinks/sites/index')
                ),
                array(
                    'label' => 'Отчеты',
                    'url' => array('/externalLinks/sites/reports'),
                ),
            )));
        ?>
    </div>
</div>

<div class="seo-table">
    <div class="table-box table-grey">
        <table>
            <colgroup>
                <col>
                <col width="300">
                <col width="40">
                <col width="100">
                <col width="140">
            </colgroup>
            <thead>
            <tr>
                <th>Внешний сайт - адрес страницы</th>
                <th>Наш сайт - адрес статьи / сервиса</th>
                <th class="ac"></th>
                <th class="ac">Стоимость<br>
                    <small>(руб.)</small>
                </th>
                <th class="ac">Дата,<br>исполнитель</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($models as $model): ?>
            <tr>
                <td style="vertical-align: top;"><a href="<?=$model->url?>" target="_blank"><?=$model->getUrlWithEmphasizedHost() ?></a></td>
                <td><a href="<?=$model->our_link?>" target="_blank"><?=$model->our_link?></a><br><?=$model->getPageTitle() ?></td>
                <td class="ac">
                    <?=$model->getLinkTypeText()?>
                </td>
                <td class="ac">
                    <?=$model->getLinkPrice()?>
                </td>
                <td class="ac">
                    <span class="date"><?=Yii::app()->dateFormatter->format('d MMM yyyy',strtotime($model->created))?></span>
                    <?=$model->author->name ?>
                </td>
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

<style type="text/css">
    .yiiPager .first, .yiiPager .previous, .yiiPager .next, .yiiPager .last {
        display: none;
    }
</style>