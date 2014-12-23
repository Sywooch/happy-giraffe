<a href="#reg-step3" class="reg-step3 display-n">Регистрация шаг 1</a>
<!-- .popup-sign-->
<script>
    $(function() {
        $('.reg-step3').magnificPopup({
            type: 'inline',
            overflowY: 'auto',
            closeOnBgClick: false,
            showCloseBtn: false,
            fixedBgPos: true,

            // When elemened is focused, some mobile browsers in some cases zoom in
            // It looks not nice, so we disable it:
            callbacks: {
                open: function() {
                    $('html').addClass('mfp-html html__reg-step3');
                },
                close: function() {
                    $('html').removeClass('mfp-html html__reg-step3');
                }
            }
        });
        $('.reg-step3').magnificPopup('open');
    });
</script>
<div id="reg-step3" class="popup popup-sign popup-sign__reg-step3">
    <div class="popup-sign_hold">
        <div class="popup-sign_top">
            <div class="popup-sign_t">Добро пожаловать, <?=Yii::app()->user->model->first_name?>!</div>
            <div class="popup-sign_slogan">А какие клубы вам понравятся? Отметьте те, которые вам интересны.</div>
        </div>
        <div class="popup-sign_cont popup-sign_cont__wide">
            <div class="club-list club-list__m clearfix">
                <div class="club-list_t">Веселый Жираф рекомендует</div>
                <?php $this->widget('application.modules.profile.widgets.ClubsWidget', array('size' => 'Big', 'signup' => true, 'all' => true, 'user' => Yii::app()->user->model)); ?>
            </div>
        </div>
    </div>
    <div class="popup-sign_b margin-t20 clearfix">
        <div class="float-r"><a class="btn-green-simple btn-l" href="<?=Yii::app()->user->getReturnUrl($this->createUrl('/profile/default/index', array('user_id' => Yii::app()->user->id)))?>">Готово</a></div>
        <div class="float-l margin-t12"><a class="color-gray" href="<?=Yii::app()->user->getReturnUrl($this->createUrl('/profile/default/index', array('user_id' => Yii::app()->user->id)))?>">Пропустить этот шаг</a></div>
    </div>
</div>
<!-- /popup-sign-->
</div>