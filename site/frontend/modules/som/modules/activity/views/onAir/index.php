<?php
/**
 * @var \site\frontend\modules\posts\modules\onAir\controllers\DefaultController $this
 */
$this->pageTitle = 'Прямой эфир';
?>

<div class="b-main_cont b-main_cont__wide">
    <!--+userSubscribers('visible-md-block')-->
    <div class="b-main_col-hold clearfix">


        <!-- Основная колонка-->
        <div class="b-main_col-article">
            <?php $this->widget('site\frontend\modules\comments\modules\contest\widgets\MyGiraffeWidget'); ?>

            <div style="text-align: center;">
                <?php
                $this->widget('zii.widgets.CMenu', array(
                    'htmlOptions' => array('class' => 'onair-filter', 'style' => 'margin-top: 20px;'),
                    'itemCssClass' => 'onair-filter_i',
                    'items'=>array(
                        array('label' => 'Все', 'url' => array('/som/activity/onAir/index'), 'active' => $filter === null),
                        array('label' => 'Записи', 'url' => array('/som/activity/onAir/index', 'filter' => 'posts')),
                        array('label' => 'Комментарии', 'url' => array('/som/activity/onAir/index', 'filter' => 'comments')),
                    ),
                ));
                ?>
            </div>

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
