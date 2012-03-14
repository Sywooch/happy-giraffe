<div class="row row-social">
    <p>Свяжите свой профиль с вашими аккаунтами на других сайтах.<br>
    Это позволит входить на сайт, используя любой из привязанных аккаунтов.</p>
    <div class="socials">
        <?php Yii::app()->eauth->renderWidget(array('mode' => 'profile', 'action' => 'site/login')); ?>
    </div>
</div>