<?php
/**
 * @var CDataProvider $dp
 * @var int $year
 * @var int $month
 * @var int $day
 */
Yii::app()->clientScript->registerPackage('lite_contentCalendar');
?>

<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <div class="b-main_col-article">
            <h1 class="heading-link-xxl">Записи от 11.08.2014</h1>
        </div>
    </div>
    <div class="b-calendar">
        <div class="b-calendar_in b-calendar_in__years">
            <div class="b-calendar_t">Год</div>
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array_map(function($y) use ($year, $month, $day) {
                    return array(
                        'label' => $y,
                        'url' => array('/blog/archive/index', 'year' => $y, 'month' => $month, 'day' => $day),
                        'linkOptions' => array('class' => 'b-calendar_a'),

                    );
                }, range(2011, 2014)),
                'htmlOptions' => array('class' => 'b-calendar_ul'),
                'itemCssClass' => 'b-calendar_li',
            )); ?>
        </div>
        <div class="b-calendar_in b-calendar_in__months">
            <div class="b-calendar_t">Месяц</div>
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array_map(function($m) use ($year, $month, $day) {
                    return array(
                        'label' => HDate::ruMonthShort($m),
                        'url' => strtotime(implode('-', array($year, $m, $day))) < time() ? array('/blog/archive/index', 'year' => $year, 'month' => $m, 'day' => $day) : null,
                        'linkOptions' => array('class' => 'b-calendar_a'),
                    );
                }, range(1, 12)),
                'htmlOptions' => array('class' => 'b-calendar_ul'),
                'itemCssClass' => 'b-calendar_li',
            )); ?>
        </div>
        <div class="b-calendar_in b-calendar_in__days">
            <div class="b-calendar_t">День</div>
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array_map(function($d) use ($year, $month, $day) {
                    return array(
                        'label' => $d,
                        'url' => strtotime(implode('-', array($year, $month, $d))) < time() ? array('/blog/archive/index', 'year' => $year, 'month' => $month, 'day' => $d) : null,
                        'linkOptions' => array('class' => 'b-calendar_a'),
                    );
                }, range(1, cal_days_in_month(CAL_GREGORIAN, $month, $year))),
                'htmlOptions' => array('class' => 'b-calendar_ul'),
                'itemCssClass' => 'b-calendar_li',
            )); ?>
        </div>
    </div>
    <div class="post-list-simple">
        <?php $this->widget('LiteListView', array(
            'dataProvider' => $dp,
            'itemView' => '_content',
        )); ?>

        <!-- Количество элементов списка 50-100 на странице-->
        <ul class="post-list-simple_ul">
            <li class="post-list-simple_li">
                <div class="post-list-simple_top"><a href="#" class="a-light">Ангелина Богоявленская</a>
                    <time datetime="2012-12-23" class="tx-date">11 августа</time>
                </div>
                <div class="post-list-simple_t"><a href="#" class="post-list-simple_t-a">Так хорошо, когда папа выходной!  </a></div>
            </li>
            <li class="post-list-simple_li">
                <div class="post-list-simple_top"><a href="#" class="a-light">Ангелина Богоявленская</a>
                    <time datetime="2012-12-23" class="tx-date">11 августа</time>
                </div>
                <div class="post-list-simple_t"><a href="#" class="post-list-simple_t-a">Теща ненавидит зятя. Внук растет без бабушки. Грустно... </a></div>
            </li>
            <li class="post-list-simple_li">
                <div class="post-list-simple_top"><a href="#" class="a-light">Ангелина Богоявленская</a>
                    <time datetime="2012-12-23" class="tx-date">11 августа</time>
                </div>
                <div class="post-list-simple_t"><a href="#" class="post-list-simple_t-a">Так хорошо, когда папа выходной!  </a></div>
            </li>
            <li class="post-list-simple_li">
                <div class="post-list-simple_top"><a href="#" class="a-light">Ангелина Богоявленская</a>
                    <time datetime="2012-12-23" class="tx-date">11 августа</time>
                </div>
                <div class="post-list-simple_t"><a href="#" class="post-list-simple_t-a">Теща ненавидит зятя. Внук растет без бабушки. Грустно... </a></div>
            </li>
            <li class="post-list-simple_li">
                <div class="post-list-simple_top"><a href="#" class="a-light">Ангелина Богоявленская</a>
                    <time datetime="2012-12-23" class="tx-date">11 августа</time>
                </div>
                <div class="post-list-simple_t"><a href="#" class="post-list-simple_t-a">Так хорошо, когда папа выходной!  </a></div>
            </li>
            <li class="post-list-simple_li">
                <div class="post-list-simple_top"><a href="#" class="a-light">Ангелина Богоявленская</a>
                    <time datetime="2012-12-23" class="tx-date">11 августа</time>
                </div>
                <div class="post-list-simple_t"><a href="#" class="post-list-simple_t-a">Про энцефалопатию. неужели эта болезнь никак не поддается лечению? или просто люди живут как овощи? </a></div>
            </li>
            <li class="post-list-simple_li">
                <div class="post-list-simple_top"><a href="#" class="a-light">Ангелина Богоявленская</a>
                    <time datetime="2012-12-23" class="tx-date">11 августа</time>
                </div>
                <div class="post-list-simple_t"><a href="#" class="post-list-simple_t-a">Марафон женственности, кто нибудь участвовал?</a></div>
            </li>
            <li class="post-list-simple_li">
                <div class="post-list-simple_top"><a href="#" class="a-light">Ангелина Богоявленская</a>
                    <time datetime="2012-12-23" class="tx-date">11 августа</time>
                </div>
                <div class="post-list-simple_t"><a href="#" class="post-list-simple_t-a">Так хорошо, когда папа выходной!  </a></div>
            </li>
            <li class="post-list-simple_li">
                <div class="post-list-simple_top"><a href="#" class="a-light">Ангелина Богоявленская</a>
                    <time datetime="2012-12-23" class="tx-date">11 августа</time>
                </div>
                <div class="post-list-simple_t"><a href="#" class="post-list-simple_t-a">Так хорошо, когда папа выходной!  </a></div>
            </li>
            <li class="post-list-simple_li">
                <div class="post-list-simple_top"><a href="#" class="a-light">Ангелина Богоявленская</a>
                    <time datetime="2012-12-23" class="tx-date">11 августа</time>
                </div>
                <div class="post-list-simple_t"><a href="#" class="post-list-simple_t-a">Так хорошо, когда папа выходной!  </a></div>
            </li>
        </ul>
    </div>
    <!-- paginator-->
    <div class="yiipagination">
        <div class="pager">
            <ul class="yiiPager">
                <li class="page"><a href="">1</a></li>
                <li class="page"><a href="">2</a></li>
                <li class="page"><a href="">5</a></li>
                <li class="page"><a href="">6</a></li>
                <li class="page selected"><a href="">7</a></li>
                <li class="page"><a href="">8</a></li>
                <li class="page"><a href="">9</a></li>
                <li class="page"><a href="">10</a></li>
                <li class="page"><a href="">11</a></li>
            </ul>
        </div>
    </div>
    <!-- /paginator-->
</div>