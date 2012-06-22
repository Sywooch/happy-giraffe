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
        <a href="" class="active">Неделя</a>
        |
        <a href="">Месяц</a>
    </div>

    <div class="table-box">
        <table>
            <thead>
            <tr>
                <th rowspan="2" class="col-1">Название статьи, ссылка</th>
                <th rowspan="2" class="col-1">Ключевые слова и фразы</th>
                <th colspan="2"><i class="icon-yandex"></i></th>
                <th colspan="2"><i class="icon-google"></i></th>
                <th rowspan="2">Общие визиты</th>
                <th rowspan="2">Sape</th>
                <th rowspan="2">Пере-<br>линковка</th>
            </tr>
            <tr>
                <th>Позиции</th>
                <th>Визиты</th>
                <th>Позиции</th>
                <th>Визиты</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($models as $model): ?>
                <tr id="key-<?=$model->id ?>">
                    <td rowspan="<?=count($model->phrases) ?>" class="col-1 row-col">
                        <?=$model->getArticleLink() ?>
                    </td>
                <?php foreach ($model->phrases as $phrase): ?>
                    <td><?=$phrase->keyword->name ?></td>
                    <td><?=$phrase->getPosition(2) ?></td>
                    <td><?=$visits1 = $phrase->getVisits(2) ?></td>
                    <td><?=$phrase->getPosition(3) ?></td>
                    <td><?=$visits2 =$phrase->getVisits(3) ?></td>
                    <td><?=($visits1+$visits2) ?></td>
                    <td><a href="javascript:;" class="icon-plus"></a></td>
                    <td><a href="javascript:;" class="icon-arr-r"></a></td>
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
