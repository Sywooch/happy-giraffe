<ul class="social-btns clearfix">
    <?php foreach ($services as $name => $service): ?>
        <li class="auth-service <?=$service->id?>"><a class="social-btn social-btn__<?=$service->id?>" href="<?=Yii::app()->createUrl($action, array('service' => $name))?>"><span class="social-btn_ico"></span><span class="social-btn_tx"><?=$service->title?></span></a></li>
    <?php endforeach; ?>
</ul>