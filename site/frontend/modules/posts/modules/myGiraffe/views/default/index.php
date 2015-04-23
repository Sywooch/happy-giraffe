<?php
/**
 * @var LiteController $this
 * @var site\frontend\modules\posts\modules\myGiraffe\components\DataProvider $dp
 */
$this->pageTitle = 'Мой Жираф';
?>

<div class="b-main_cont b-main_cont__wide">


    <!--+userSubscribers('visible-md-block')-->
    <div class="b-main_col-hold clearfix">
        <!--/////-->
        <!-- Основная колонка-->
        <div class="b-main_col-article">
            <!-- Статья с текстом-->
            <!-- b-article-->
            <?php
                $this->widget('LiteListView', array(
                    'dataProvider' => $dp,
                    'itemView' => 'posts.views.list._view',
                    'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
                    'pager' => array(
                        'class' => 'LitePager',
                        'maxButtonCount' => 10,
                        'prevPageLabel' => '&nbsp;',
                        'nextPageLabel' => '&nbsp;',
                        'showPrevNext' => true,
                    ),
                ));
            ?>
        </div>
        <!-- /Основная колонкa-->

        <!--/////-->
        <!-- Сайд бар-->
        <!-- Содержимое загружaть отложено-->
        <aside class="b-main_col-sidebar visible-md">
            <div class="bnr-sidebar"><a href="<?=$this->createUrl('subscriptions/index')?>"> <img src="/lite/images/banner/mygiraffe.png" alt=""></a></div>
        </aside>
    </div>
</div>