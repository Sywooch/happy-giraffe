<div class="margin-b30 clearfix">
    Свяжите свой профиль с вашими аккаунтами на других сайтах. <br>Это позволит входить на сайт, используя любой из привязанных аккаунтов.
</div>
<!-- Пока нет связаных соц. сетей, таблицы тоже нет -->
<?php Yii::app()->eauth->renderWidget(array('mode' => 'profile', 'action' => 'site/login', 'predefinedServices' => array('odnoklassniki', 'mailru', 'facebook', 'vkontakte'))); ?>

