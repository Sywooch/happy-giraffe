<div id="reg-odnoklassniki" style="display: none;">
    <div class="register-social clearfix">

        <div class="block-title">Стань другом Веселого Жирафа!</div>

        <div class="hl">
            Быстрая регистрация с помощью Одноклассников. <span>Нажми на кнопку!</span>
        </div>

        <div class="social-btn">
            <?=HHtml::link('<img src="/images/btn_register_big_ok.png">', Yii::app()->createUrl('signup/index', array('service' => 'odnoklassniki')), array('class' => 'auth-service2 odnoklassniki'), true) ?>
        </div>

    </div>
    <div class="is-user">
        Вы уже зарегистрированы? <a href="#login" class="fancy" data-theme="white-square">Войти</a>
    </div>
</div>