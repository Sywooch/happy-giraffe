<div class="ico-social-hold">
    <?php foreach ($services as $name => $service): ?>
    <span class="auth-service <?=$service->id?>"><a href="<?=Yii::app()->createUrl($action, array('service' => $name))?>" class="ico-social ico-social__m ico-social__<?=$service->id?>"></a></span>
    <?php endforeach; ?>
</div>