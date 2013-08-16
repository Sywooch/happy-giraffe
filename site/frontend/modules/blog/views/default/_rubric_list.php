<?php
$rubric_list = $this->user->blog_rubrics;
if ($this->user->id != Yii::app()->user->id) {
    $rubric_ids = CommunityRubric::notEmptyUserRubricIds($this->user->id);
    foreach ($rubric_list as $key => $rubric)
        if (!in_array($rubric->id, $rubric_ids))
            unset($rubric_list[$key]);
}

?><div class="menu-simple blogInfo">
    <?php $this->widget('zii.widgets.CMenu', array(
        'items' =>
        array_map(function ($rubric) {
            return array(
                'label' => $rubric->title,
                'url' => $rubric->getUrl(),
                'linkOptions' => array('class' => 'menu-simple_a'),
                'active' => $rubric->id == Yii::app()->controller->rubric_id
            );
        }, $rubric_list),
        'itemCssClass'=>'menu-simple_li',
        'htmlOptions'=>array('class'=>'menu-simple_ul')
    ));
    ?>
</div>