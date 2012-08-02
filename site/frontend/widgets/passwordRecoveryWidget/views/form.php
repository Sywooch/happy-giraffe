<?php
    $cs = Yii::app()->clientScript;

    $cs
        ->registerScriptFile('/javascripts/jquery.flip.js')
    ;
?>

<div style="display:none">
    <div id="passwordRecovery" class="popup">

        <a href="javascript:void(0);" class="popup-close tooltip" onclick="$.fancybox.close()" title="Закрыть"></a>

        <div class="block-title"><img src="/images/bg_register_title.png" />Забыли пароль?</div>

        <div class="password-retrieve">

            <div class="block-in">

                <p>Пожалуйста введите ваш e-mail адрес. <br/>Вам будет выслано письмо с вашим паролем.</p>

                <div class="input">
                    <label>E-mail:</label>
                    <input type="text" />
                </div>

                <div class="sent">
                    <span>На ваш e-mail адрес было выслано письмо с вашим паролем</span><br/>
                    <span>(также проверьте, пожалуйста, папку «Спам»)</span>
                </div>

            </div>

            <input type="submit" value="Отправить" />

        </div>

    </div>
</div>