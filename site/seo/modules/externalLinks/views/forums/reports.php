<?php
/* @var $this Controller
 * @var $models ELLink[]
 */
?>
<div class="ext-links-add">

    <?php $this->renderPartial('sub_menu')?>

</div>

<div class="seo-table">
    <p>Всего ссылок: <?=ELLink::model()->with('site')->count('site.type = 2'); ?></p>

    <div class="table-box table-grey">
        <table>
            <thead>
            <tr>
                <th>Форум - адрес страницы</th>
                <th>Наш сайт - адрес статьи / сервиса</th>
                <th class="ac">Дата,<br>исполнитель</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($models as $model): ?>
            <tr>
                <td style="vertical-align: top;"><a href="<?=$model->url?>" target="_blank"><?=$model->getUrlWithEmphasizedHost() ?></a></td>
                <td><a href="<?=$model->our_link?>" target="_blank"><?=$model->our_link?></a><br><?=$model->getPageTitle() ?></td>
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