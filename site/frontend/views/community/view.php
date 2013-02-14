<?php
/* @var $this CommunityController
 * @var $data CommunityContent
*/

$this->renderPartial('_post', array('data' => $data, 'full' => true));

$this->renderPartial('_prev_next', array('data' => $data));
?>

<?php if ($data->id == 59468): ?>
<div class="valentine-banner">
    <div class="valentine-banner_hold">
        <div class="valentine-banner_h">
            <div class="valentine-banner_t">500</div>
            валентинок
        </div>
        <a href="<?=Yii::app()->createUrl('/valentinesDay/default/valentines', array('open_photo_id' => 302388))?>" class="valentine-banner_btn btn-green btn-big">Выбери свою</a>
    </div>
    <a href="<?=Yii::app()->createUrl('/valentinesDay/default/valentines', array('open_photo_id' => 302686))?>" class="valentine-banner_img valentine-banner_img__1"></a>
    <a href="<?=Yii::app()->createUrl('/valentinesDay/default/valentines', array('open_photo_id' => 302444))?>" class="valentine-banner_img valentine-banner_img__2"></a>
    <a href="<?=Yii::app()->createUrl('/valentinesDay/default/valentines', array('open_photo_id' => 302437))?>" class="valentine-banner_img valentine-banner_img__3"></a>
</div>
<?php endif; ?>

<?php

$this->widget('application.widgets.commentWidget.CommentWidget', array('model' => $data));

$this->widget('application.widgets.seo.SeoLinksWidget');

$remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
$remove_tmpl->registerTemplates();
$this->endWidget();
