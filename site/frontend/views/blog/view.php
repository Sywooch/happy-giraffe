<?php $this->renderPartial('/community/_post', array('data' => $data, 'full' => true)); ?>

<?php if ($data->type_id != 5): ?>
<?php $this->renderPartial('/community/_prev_next', array('data' => $data)); ?>
<?php endif; ?>

<div class="valentine-banner">
    <div class="valentine-banner_hold">
        <div class="valentine-banner_h">
            <div class="valentine-banner_t">500</div>
            валентинок
        </div>
        <a href="http://www.happy-giraffe.ru/ValentinesDay/valentines/?open_photo_id=302388" class="valentine-banner_btn btn-green btn-big">Выбери свою</a>
    </div>
    <a href="http://www.happy-giraffe.ru/ValentinesDay/valentines/?open_photo_id=302686" class="valentine-banner_img valentine-banner_img__1"></a>
    <a href="http://www.happy-giraffe.ru/ValentinesDay/valentines/?open_photo_id=302444" class="valentine-banner_img valentine-banner_img__2"></a>
    <a href="http://www.happy-giraffe.ru/ValentinesDay/valentines/?open_photo_id=302437" class="valentine-banner_img valentine-banner_img__3"></a>
</div>

<?php $this->widget('application.widgets.commentWidget.CommentWidget', array(
    'model' => $data,
)); ?>

<?php $this->widget('application.widgets.seo.SeoLinksWidget'); ?>

<?php
$remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
$remove_tmpl->registerTemplates();
$this->endWidget();
?>