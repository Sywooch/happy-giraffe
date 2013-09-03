<?php
/**
 * @var CommunitySection $section
 */
?>
<div class="b-section b-section__collection">
    <div class="b-section_hold">
        <div class="b-section_collection">
            <img src="/images/club/collection/<?= $section->id ?>.png" alt="" class="b-section_collection-img">

            <div class="b-section_collection-t"><?= $section->title ?></div>
        </div>
    </div>
</div>

<div class="content-cols clearfix">
    <div class="col-1">

        <?php $this->widget('application.modules.profile.widgets.ClubsWidget', array(
            'user' => Yii::app()->user->getModel(),
            'clubs' => CHtml::listData($section->clubs, 'id', 'id'),
            'size'=>'Community'
        )); ?>

    </div>

    <div class="col-23-middle ">
        <div class="col-gray">
            <div class="heading-medium margin-20">Прямой эфир</div>

            <?php
            $this->widget('zii.widgets.CListView', array(
                'cssFile' => false,
                'ajaxUpdate' => false,
                'dataProvider' => CommunityContent::model()->getSectionContents($section->id),
                'itemView' => 'blog.views.default.view',
                'pager' => array(
                    'class' => 'HLinkPager',
                ),
                'template' => '{items}
                    <div class="yiipagination">
                        {pager}
                    </div>
                ',
                'emptyText' => '',
                'viewData' => array('full' => false),
            ));

            ?>

        </div>
    </div>
</div>