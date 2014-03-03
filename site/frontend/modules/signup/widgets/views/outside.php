<ul class="display-ib verticalalign-m">
    <?php foreach ($services as $name => $service): ?>
        <li class="display-ib auth-service <?=$service->id?>"><a class="custom-like" href="<?=Yii::app()->createUrl($action, array('service' => $name))?>"><span class="custom-like_icon <?=$service->id?>"></span></a></li>
    <?php endforeach; ?>
</ul>