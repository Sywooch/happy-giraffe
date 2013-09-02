<div id="passwordRecovery" class="popup">

    <?=CHtml::beginForm(array('site/passwordRecovery'), 'post', array('onsubmit' => 'PasswordRecovery.send(this); return false;'))?>

    <a href="javascript:void(0);" class="popup-close tooltip" onclick="$.fancybox.close()" title="Закрыть"></a>

    <div class="block-title"><img src="/images/bg_register_title.png" />Забыли пароль?</div>

    <div class="password-retrieve">

        <div class="block-in">

            <p>Пожалуйста введите ваш e-mail адрес. <br/>Вам будет выслано письмо с вашим паролем.</p>

            <div class="input">
                <label>E-mail:</label>
                <input type="text" name="email" />
            </div>

            <div class="sent" style="display: none;"></div>

        </div>

        <input type="submit" value="Отправить" />

    </div>

    <?=CHtml::endForm()?>

</div>