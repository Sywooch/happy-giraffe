<?php
/**
 * @var SettingsController $this
 */
?>
<div class="margin-b30 clearfix">
    Свяжите свой профиль с вашими аккаунтами в других социальных сетях. <br>Это позволит входить на сайт, используя любой из привязанных аккаунтов.
</div>
<!-- Пока нет связаных соц. сетей, таблицы тоже нет -->
<?php $this->widget('ProfileAuthWidget', array('action' => '/profile/settings/socialAuth')); ?>

