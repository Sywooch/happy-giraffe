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
            <?php
            $this->widget('site\frontend\modules\som\modules\activity\widgets\ActivityWidget', array(
                'pageVar' => 'page',
                'view' => 'simple',
                'pageSize' => 5,
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
