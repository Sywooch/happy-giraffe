<?php
/* @var $this Controller
 * @var $up IndexingUp
 */
?>
<div class="indexation">

    <div class="block-title">Апдейт</div>

    <div class="clearfix">

        <div class="date">
            <form action="">
                <?=CHtml::dropDownList('up_id', $up->id, CHtml::listData(IndexingUp::model()->findAll(), 'id', 'date'), array('onchange'=>'$(this).parents("form").submit();')) ?>
            </form>
        </div>

        <div class="dates">
            <ul>
                <!--                <li><a href="">01 сен 2012</a></li>-->
                <!--                <li><a href="">02 сен 2012</a></li>-->
                <!--                <li class="active"><a href="">--><?//= $up->date ?><!--</a></li>-->
            </ul>
        </div>

    </div>

    <?php if($this->beginCache('indexation-'.$up->id, array('dependency'=>array(
    'class'=>'system.caching.dependencies.CDbCacheDependency',
    'sql'=>'SELECT count(id) FROM happy_giraffe_seo.indexing__up_urls WHERE up_id='.$up->id)))) { ?>
    <div class="text">
        <?php $addUrls = $up->getUrls(true);
        $removeUrls = $up->getUrls(false);
        $income = count($addUrls) - count($removeUrls);
        ?>
        <p><span><?=Yii::app()->dateFormatter->format('dd MMMM yyyy', strtotime($up->date))?></span> Яндекс добавил в
            индекс <a href="javascript:;" onclick="Indexing.showAddUrls()"><?=count($addUrls) ?> страниц</a>, удалил <a
                href="javascript:;" onclick="Indexing.showRemoveUrls();" class="red"><?=count($removeUrls) ?>
                страниц</a>.</p>

        <p><span>Итого в индексе</span> <?= count($up->text_urls) ?> (<?=$income > 0 ? '+' . $income : $income ?>) страниц</p>

    </div>

</div>

<div id="add-urls" class="seo-table" style="display: none;">

    <div class="table-box">
        <table>
            <thead>
            <tr>
                <th class="al"><span class="big">Ссылка</span></th>
                <th class="al"><span class="big">Название страницы</span></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($addUrls as $url): ?>
                    <tr>
                        <td class="al"><span class="big"><a href="<?=$url ?>" target="_blank"><?=$url ?></a></span>
                        </td>
                        <td class="al"><span class="big"><b><?php //echo $url->url->getTitle() ?></b></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="remove-urls" class="seo-table" style="display: none;">

    <div class="table-box">
        <table>
            <thead>
            <tr>
                <th class="al"><span class="big">Ссылка</span></th>
                <th class="al"><span class="big">Название страницы</span></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($removeUrls as $url): ?>
            <tr>
                <td class="al"><span class="big"><a href="<?=$url ?>" target="_blank"><?=$url ?></a></span>
                </td>
                <td class="al"><span class="big"><b><?php //echo $url->url->getTitle() ?></b></span></td>
            </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->endCache(); } ?>