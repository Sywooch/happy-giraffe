<?php
/* @var $this DefaultController */

//выбираем 3 понедельника - 2 предыдущих и один следующий
$days = array();
$next_monday = strtotime('next monday');
$days [] = date("Y-m-d", $next_monday);
for ($i = 1; $i <= 2; $i++) {
    $days [] = date("Y-m-d", strtotime('-'.(7*$i).' days', $next_monday));
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
                <div class="best-list best-list__mail">
                    <ul id="sortable<?= $i ?>" class="best-list_ul" data-date="<?= $day ?>">
                        <?php $models = Favourites::getListByDate(Favourites::WEEKLY_MAIL, $day) ?>
                        <?php foreach ($models as $model): ?>
                            <?php $article = $model->getArticle() ?>
                            <li class="best-list_li b-best_i" id="<?= $model->_id ?>">
                                <b class="best-list_t"><a href=""><?= $article->title ?></a></b>

                                <div class="best-list_tx"><?= $article->getShort(200); ?></div>
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
<script type="text/javascript">
    $(function () {
        $("#sortable1, #sortable2, #sortable3").sortable({
            connectWith: ".best-list_ul",
            update: function (event, ui) {
                var id = ui.item[0].id;
                var new_list_index = ui.item.index();
                var date = ui.item.parents('ul').data('date');

                $.post('/best/newPos/', {id: id, index: new_list_index, date: date}, function (response) {
                    if (!response.status) {
                        alert('Ошибка, обратитесь к разработчику');
                    }
                }, 'json');
            }
        }).disableSelection();
    });
</script>
<style type="text/css">
    .best-list_ul {
        min-width: 300px;
        min-height: 50px;
    }
</style>