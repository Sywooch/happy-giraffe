<div id="login-retrieve" class="popup-sign">
    <a class="popup-transparent-close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
    <div class="clearfix">
        <div class="w-830">

            <div class="b-settings-blue">
                <div class="b-sign">
                    <div class="b-sign_t">
                        <span class="ico-lock-big"></span>
                        Забыли пароль?
                    </div>

                    <div class="b-sign_retrieve clearfix">
                        <?=CHtml::beginForm(array('site/passwordRecovery'), 'post', array('onsubmit' => 'PasswordRecovery.send(this); return false;'))?>
                        <div class="b-sign_retrieve-hold">
                            <div class="margin-b20 clearfix">
                                Пожалуйста введите ваш e-mail адрес. <br> Вам будет выслано письмо с вашим паролем.
                            </div>
                            <div class="clearfix">
                                <div class="b-sign_label-hold">
                                    <label class="b-sign_label">E-mail</label>
                                </div>
                                <div class="b-sign_itx-hold w-300">
                                    <input type="text" name="email" class="itx-simple">
                                    <div class="errorMessage recovery-fail" style="display: none;">Произошла неизвестная ошибка. Попробуйте ещё раз.</div>
                                </div>
                                <button class="btn-green btn-medium">Ok</button>
                            </div>
                            <div class="b-sign_retrieve-send recovery-success" style="display: none;">
                                <div class="clearfix">
                                    <span class="i-highlight">На ваш e-mail адрес было выслано письмо с вашим паролем.</span>
                                </div>
                                <div class="clearfix">
                                    <span class="i-highlight">Также проверьте, пожалуйста, папку «Спам».</span>
                                </div>
                            </div>
                        </div>
                        <button class="float-r btn-blue btn-h46 recovery-success" style="display: none;">Вход на сайт</button>
                        <?=CHtml::endForm()?>
                    </div>


                </div>



            </div>

        </div>
    </div>
</div>