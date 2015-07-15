<?php
/**
 * @var \site\frontend\modules\posts\modules\onAir\controllers\DefaultController $this
 */
$this->pageTitle = 'Прямой эфир';
?>

<div class="b-main_cont b-main_cont__wide">
    <?php
    $this->widget('zii.widgets.CMenu', array(
        'htmlOptions' => array('class' => 'filter-group'),
        'itemCssClass' => 'filter-group_i',
        'items'=>array(
            array('label' => 'Все', 'url' => array('/som/activity/onAir/index', 'filter' => 'all'), 'active' => $filter === null),
            array('label' => 'Комментарии', 'url' => array('/som/activity/onAir/index', 'filter' => 'comments')),
            array('label' => 'Записи', 'url' => array('/som/activity/onAir/index', 'filter' => 'posts')),
        ),
    ));
    ?>

    <!--+userSubscribers('visible-md-block')-->
    <div class="b-main_col-hold clearfix">
        <!-- Основная колонка-->
        <div class="b-main_col-article">
            <?php
            $this->widget('site\frontend\modules\som\modules\activity\widgets\ActivityWidget', array(
                'pageVar' => 'page',
                'view' => 'simple',
                'pageSize' => 25,
                'criteria' => $criteria,
            ));
            ?>
        </div>
        <!-- /Основная колонкa-->
        <!--/////-->
        <!-- Сайд бар-->
        <!-- Содержимое загружaть отложено-->
        <aside class="b-main_col-sidebar visible-md">
            <?php
            $this->widget('site\frontend\modules\som\modules\activity\widgets\ActivityUsersWidget');
            ?>
        </aside>
        <!--/////-->


    </div>
</div>
