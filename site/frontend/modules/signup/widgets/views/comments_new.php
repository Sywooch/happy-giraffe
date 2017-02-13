<div class="b-margin--bottom_20">
    <div class="social-widget social-widget--theme-pediatr">Ответить от
        <ul class="social-widget__list social-widget-post social-widget-post--theme-pediatr">

            <?php foreach ($services as $name => $service): ?>

                <li class="social-widget-post__li auth-service <?= $service->id; ?>">
                    <a href="<?= Yii::app()->createUrl($action, array('service' => $name)); ?>" class="social-widget-post__link social-widget-post__link--<?=$service->id?>"></a>
                </li>

            <?php endforeach; ?>

        </ul>
        или
        <a href="javascript:void(0);" class="social-widget__auth login-button" data-bind="follow: {}">Войти</a>
    </div>
</div>