<?php
/**
 * @var CActiveForm $form
 * @var User $model
 */
?>

<div class="popup-sign_top">
    <div class="popup-sign_t">Регистрация на Веселом Жирафе</div>
    <div class="popup-sign_slogan">Стань полноправным участником сайта за 1 минуту!</div>
</div>
<div class="popup-sign_cont">
    <div class="popup-sign_social">
        <div class="popup-sign_row">
            <div class="popup-sign_label">С помощью социальных сетей</div>
        </div>
        <?php $this->widget('AuthWidget', array('action' => '/signup/default/social')); ?>
    </div>
    <div class="popup-sign_col">
        <div class="popup-sign_row">
            <div class="popup-sign_label">Адрес активной электронной почты</div>
        </div>
        <div class="popup-sign_row">
            <div class="inp-valid inp-valid__abs">
                <?=$form->textField($model, 'email', array(
                    'placeholder' => 'E-mail',
                    'class' => 'itx-gray popup-sign_itx',
                    'data-bind' => 'value: email',
                ))?>
                <div class="inp-valid_error">
                    <?=$form->error($model, 'email')?>
                </div>
                <div class="inp-valid_success inp-valid_success__ico-check"></div>
            </div>
        </div>
        <div class="popup-sign_row">
            <div class="popup-sign_label">Полное имя</div>
        </div>
        <div class="popup-sign_row">
            <div class="inp-valid inp-valid__abs">
                <?=$form->textField($model, 'first_name', array(
                    'placeholder' => 'Имя',
                    'class' => 'itx-gray popup-sign_itx',
                    'data-bind' => 'value: first_name',
                ))?>
                <div class="inp-valid_error">
                    <?=$form->error($model, 'first_name')?>
                </div>
                <div class="inp-valid_success inp-valid_success__ico-check"></div>
            </div>
        </div>
        <div class="popup-sign_row">
            <div class="inp-valid inp-valid__abs">
                <?=$form->textField($model, 'last_name', array(
                    'placeholder' => 'Фамилия',
                    'class' => 'itx-gray popup-sign_itx',
                    'data-bind' => 'value: last_name',
                ))?>
                <div class="inp-valid_error">
                    <?=$form->error($model, 'last_name')?>
                </div>
                <div class="inp-valid_success inp-valid_success__ico-check"></div>
            </div>
        </div>
        <div class="popup-sign_row">
            <button class="btn-green-simple btn-l">Зарегистрироваться</button>
        </div>
        <div class="popup-sign_row">
            <div class="popup-sign_tx-help">Продолжая, вы соглашаетесь с нашими  <a class="a-color-gray-light">Условиями использования</a>,<a class="a-color-gray-light">Политикой конфиденциальности </a>и <a class="a-color-gray-light">Положениями о Cookie</a></div>
        </div>
    </div>
</div>
<div class="popup-sign_b"><span class="popup-sign_b-tx">Вы уже зарегистрированы?</span><a class="popup-sign_b-a">Войти</a></div>