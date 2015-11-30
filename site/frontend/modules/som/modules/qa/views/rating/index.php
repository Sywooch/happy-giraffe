<?php
/**
 * @var site\frontend\modules\som\modules\qa\controllers\RatingController $this
 * @var \CActiveDataProvider $dp
 */
$this->sidebar = array('personal', 'menu');
?>
<div class="heading-link-xxl"> Рейтинг</div>
<?php
$this->widget('zii.widgets.CMenu', array(
    'htmlOptions' => array(
        'class' => 'filter-menu',
    ),
    'itemCssClass' => 'filter-menu_item',
    'items' => array_map(function($periodData, $periodId) {
        return array(
            'label' => $periodData['label'],
            'url' => ($periodId == 'day') ? array('/som/qa/rating/index') : array('/som/qa/rating/index', 'period' => $periodId),
            'linkOptions' => array('class' => 'filter-menu_item_link'),
        );
    }, Yii::app()->controller->module->periods, array_keys(Yii::app()->controller->module->periods)),
));
?>

<?php
$this->widget('LiteListView', array(
    'dataProvider' => $dp,
    'itemView' => '_row',
    'htmlOptions' => array(
        'class' => 'faq-rating'
    ),
    'itemsTagName' => 'ul',
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

<?php if (false): ?>
<ul class="faq-rating">
    <li class="faq-rating_item">
        <!-- ava--><a href="#" class="ava ava ava__female"><span class="ico-status ico-status__online"></span><img alt="" src="" class="ava_img"></a><a class="faq-rating_item_link">Алиса Загорская</a>
        <div class="faq-rating_item_counters"><span>Вопросов 300</span><span>Ответов 10</span></div>
        <div class="users-rating yellow-crown">
            <div class="users-rating_crown-big"></div>
            <div class="users-rating_counter">300</div>
        </div>
        <div class="clearfix"></div>
    </li>

    <li class="faq-rating_item">
        <!-- ava--><a href="#" class="ava ava ava__female"><span class="ico-status ico-status__online"></span><img alt="" src="" class="ava_img"></a><a class="faq-rating_item_link">Алиса Загорская</a>
        <div class="faq-rating_item_counters"><span>Вопросов 300</span><span>Ответов 10</span></div>
        <div class="users-rating orange-crown">
            <div class="users-rating_crown-big"></div>
            <div class="users-rating_counter">300</div>
        </div>
        <div class="clearfix"></div>
    </li>
    <li class="faq-rating_item">
        <!-- ava--><a href="#" class="ava ava ava__female"><span class="ico-status ico-status__online"></span><img alt="" src="" class="ava_img"></a><a class="faq-rating_item_link">Алиса Загорская</a>
        <div class="faq-rating_item_counters"><span>Вопросов 300</span><span>Ответов 10</span></div>
        <div class="users-rating nocrown">
            <div class="users-rating_crown-big"></div>
            <div class="users-rating_counter">300</div>
        </div>
        <div class="clearfix"></div>
    </li>
    <li class="faq-rating_item">
        <!-- ava--><a href="#" class="ava ava ava__female"><span class="ico-status ico-status__online"></span><img alt="" src="" class="ava_img"></a><a class="faq-rating_item_link">Алиса Загорская</a>
        <div class="faq-rating_item_counters"><span>Вопросов 300</span><span>Ответов 10</span></div>
        <div class="users-rating nocrown">
            <div class="users-rating_crown-big"></div>
            <div class="users-rating_counter">300</div>
        </div>
        <div class="clearfix"></div>
    </li>
    <li class="faq-rating_item">
        <!-- ava--><a href="#" class="ava ava ava__female"><span class="ico-status ico-status__online"></span><img alt="" src="" class="ava_img"></a><a class="faq-rating_item_link">Алиса Загорская</a>
        <div class="faq-rating_item_counters"><span>Вопросов 300</span><span>Ответов 10</span></div>
        <div class="users-rating nocrown">
            <div class="users-rating_crown-big"></div>
            <div class="users-rating_counter">300</div>
        </div>
        <div class="clearfix"></div>
    </li>
    <li class="faq-rating_item">
        <!-- ava--><a href="#" class="ava ava ava__female"><span class="ico-status ico-status__online"></span><img alt="" src="" class="ava_img"></a><a class="faq-rating_item_link">Алиса Загорская</a>
        <div class="faq-rating_item_counters"><span>Вопросов 300</span><span>Ответов 10</span></div>
        <div class="users-rating nocrown">
            <div class="users-rating_crown-big"></div>
            <div class="users-rating_counter">300</div>
        </div>
        <div class="clearfix"></div>
    </li>
    <li class="faq-rating_item">
        <!-- ava--><a href="#" class="ava ava ava__female"><span class="ico-status ico-status__online"></span><img alt="" src="" class="ava_img"></a><a class="faq-rating_item_link">Алиса Загорская</a>
        <div class="faq-rating_item_counters"><span>Вопросов 300</span><span>Ответов 10</span></div>
        <div class="users-rating nocrown">
            <div class="users-rating_crown-big"></div>
            <div class="users-rating_counter">300</div>
        </div>
    </li>
    <div class="clearfix"></div>
</ul>
<div class="questions_pagination">
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
                <li class="page hidden"><a href="">11</a></li>
            </ul>
        </div>
    </div>
    <!-- /paginator-->
</div>
<?php endif; ?>