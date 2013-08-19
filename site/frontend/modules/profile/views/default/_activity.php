<?php if (Yii::app()->user->id == $user->id):?>
<div class="user-add-record clearfix">
    <div class="user-add-record_ava-hold">
        <?php $this->widget('Avatar', array('user' => Yii::app()->user->getModel())); ?>
    </div>
    <div class="user-add-record_hold">
        <div class="user-add-record_tx">Я хочу добавить</div>
        <a href="<?=$this->createUrl('/blog/default/form', array('type' => 1))?>"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__article fancy">Статью</a>
        <a href="<?=$this->createUrl('/blog/default/form', array('type' => 3))?>"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__photo fancy">Фото</a>
        <a href="<?=$this->createUrl('/blog/default/form', array('type' => 2))?>"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__video fancy">Видео</a>
        <a href="<?=$this->createUrl('/blog/default/form', array('type' => 5))?>"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__status fancy">Статус</a>
    </div>
</div>
<?php endif ?>
<?php
Yii::app()->clientScript->registerPackage('ko_blog');
$this->widget('zii.widgets.CListView', array(
    'cssFile' => false,
    'ajaxUpdate' => false,
    'dataProvider' => CommunityContent::model()->getBlogContents($user->id, null),
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