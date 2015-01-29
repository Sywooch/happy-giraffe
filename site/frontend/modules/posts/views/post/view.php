<?php
Yii::app()->clientScript->registerAMD('BlogRecordSettings', array('kow'));
/** @todo перенести обработку $this->post->metaObject в контроллер */
$this->pageTitle = $this->post->title;
$this->metaDescription = $this->post->metaObject->description;
$this->metaNoindex = $this->post->isNoindex;
$this->breadcrumbs = array(
    '<span class="ava ava__small">' . CHtml::image($this->user->avatarUrl, $this->user->fullName, array('class' => 'ava_img')) . "</span>" => $this->user->profileUrl,
    'Блог' => Yii::app()->createUrl('/blog/default/index', array('user_id' => $this->user->id)),
    $this->post->title,
);
?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <?php
        $this->renderPartial('site.frontend.modules.posts.views.post._view');
        ?>
    </div>
</div>