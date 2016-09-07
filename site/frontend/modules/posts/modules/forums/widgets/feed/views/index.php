<?php
/**
 * @var \site\frontend\modules\posts\modules\forums\widgets\feed\FeedWidget $this
 * @var CActiveDataProvider $dp
 */
?>


<div class="tabs clearfix visible-md">
    <?php $this->widget('zii.widgets.CMenu', [
        'items' => $this->getMenuItems(),
        'htmlOptions' => [
            'class' => 'filter-menu filter-menu_position',
        ],
        'itemCssClass' => 'filter-menu_item',
    ]); ?>

    <?php if ($this->getShowFilter()): ?>
        <div class="b-dropdown-cat b-dropdown-cat_position">
            <?=CHtml::dropDownList('feedForumId', Yii::app()->request->url, $this->getFilterItems(), [
                'class' => 'js-dropdown__select dropdown__select',
                'encode' => false,
                'onchange' => "js: location.href = $(this).find(':selected').val()",
            ])?>
        </div>
    <?php endif; ?>
</div>

<?php
$this->widget('LiteListView', array(
    'dataProvider' => $this->getListDataProvider(),
    'itemView' => 'posts.modules.forums.views._post',
    'htmlOptions' => [
        'class' => 'b-main_col-article',
    ],
));
?>
