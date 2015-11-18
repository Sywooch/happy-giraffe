<?php
/**
 * @var site\frontend\modules\som\modules\qa\controllers\DefaultController $this
 * @var \CActiveDataProvider $dp
 */
?>
<div class="heading-link-xxl"> Вопрос-ответ</div>
<div class="info-search">
    <input type="text" placeholder="Найти ответ" class="info-search_itx info-search_normal info-search_tablet info-search_mobile">
    <button class="info-search_btn"></button>
</div>
<?php
$this->widget('zii.widgets.CMenu', array(
    'htmlOptions' => array(
        'class' => 'filter-menu',
    ),
    'itemCssClass' => 'filter-menu_item',
    'items' => array(
        array(
            'label' => 'Новые',
            'url' => array('/som/qa/default/index', 'tab' => $this::TAB_NEW),
            'linkOptions' => array('class' => 'filter-menu_item_link'),
        ),
        array(
            'label' => 'Популярные',
            'url' => array('/som/qa/default/index', 'tab' => $this::TAB_POPULAR),
            'linkOptions' => array('class' => 'filter-menu_item_link')
        ),
        array(
            'label' => 'Без ответа',
            'url' => array('/som/qa/default/index', 'tab' => $this::TAB_UNANSWERED),
            'linkOptions' => array('class' => 'filter-menu_item_link')
        ),
    ),
));
?>
<div class="clearfix"></div>

<?php
$this->widget('LiteListView', array(
    'dataProvider' => $dp,
    'itemView' => '_question',
    'htmlOptions' => array(
        'class' => 'questions'
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