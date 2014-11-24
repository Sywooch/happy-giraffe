<ul class="ico-social-ul">
    <?php foreach ($services as $name => $service): ?>
        <li class="ico-social-ul_li auth-service <?=$service->id?>"><a href="<?=Yii::app()->createUrl($action, array('service' => $name))?>" class="ico-social ico-social__m ico-social__<?=$service->id?>"></a></li>
    <?php endforeach; ?>
</ul>