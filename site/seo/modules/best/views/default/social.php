<?php
/* @var $this DefaultController */

$days = array();
for ($i = -1; $i < 2; $i++) {
    $days [] = date("Y-m-d", strtotime('-' . $i . ' days'));
}
$i = 1;
?>
<div class="block">
    <?php foreach ($days as $day): ?>
        <div class="clearfix<?php if ($day == date("Y-m-d")) echo ' b-best__today' ?>">
            <div class="b-best">
                <div class="clearfix margin-b20">
                    <div class="b-date"><?= Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($day)) ?></div>
                </div>
                <div class="best-list">
                    <ul id="sortable<?= $i ?>" class="best-list_ul" data-date="<?= $day ?>">
                        <?php $models = Favourites::getListByDate(Favourites::BLOCK_SOCIAL_NETWORKS, $day) ?>
                        <?php foreach ($models as $model): ?>
                            <?php $article = $model->getArticle() ?>
                            <li class="best-list_li b-best_i" id="<?= $model->_id ?>">
                                <b class="best-list_t"><a href=""><?= $article->title ?></a></b>

                                <div class="best-list_tx"><?= $article->getShort(100); ?></div>
                                <div class="b-best_overlay">
                                    <div class="b-best_overlay-tx">
                                        Вы можете переместить или удалить. <br>
                                        <a href="http://www.happy-giraffe.ru<?= $article->url ?>" target="_blank">Перейти
                                            на пост</a>
                                    </div>
                                </div>
                                <a href="javascript:;" class="b-best_close"
                                   onclick="EditFavourites.remove('<?= $model->_id ?>', this);"></a>
                                <a href="" class="b-best_drag"></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php $i++; ?>
    <?php endforeach; ?>

</div>