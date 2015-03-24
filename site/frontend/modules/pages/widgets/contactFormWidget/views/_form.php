<?php
/**
 * @var \CActiveForm $form
 * @var site\frontend\modules\pages\widgets\contactFormWidget\models\ContactForm $model
 */
Yii::app()->clientScript->registerAMD('contactForm', array('ContactForm' => 'contactForm', 'ko' => 'knockout'), "a = new ContactForm(); ko.applyBindings(a, document.getElementById('contactForm'));");
?>
<div class="info-form" id="contactForm">
    <div class="info-form-title">Напишите нам</div>
    <div class="info-hero-line">Чем мы можем Вам помочь?</div>
    <div class="info-form-block">
        <div class="info-form-block__part">
            <textarea name="" cols="30" rows="10" placeholder="Введите сообщение" class="itx-gray form-edit_itx" data-bind="textInput: message"></textarea>
        </div>
        <div class="info-form-block__part">
            <input type="text" placeholder="Имя" class="info-form__input itx-gray form-edit_itx" data-bind="textInput: name">
            <input type="text" placeholder="Компания" class="info-form__input itx-gray form-edit_itx" data-bind="textInput: companyName">
            <input type="text" placeholder="Email" class="info-form__input itx-gray form-edit_itx" data-bind="textInput: email">
            <input type="text" placeholder="Телефон" class="info-form__input itx-gray form-edit_itx" data-bind="textInput: phone">
            <!-- ko if: attach() === false -->
            <div class="info-form__file file-fake">Прикрепить файл
                <input type="file" name="file">
            </div>
            <!-- /ko -->
            <!-- ko if: attach() !== false -->
            <span data-bind="text: attach().fileName"></span>
            <!-- /ko -->
        </div>
    </div>
    <div class="info-form-ms text-center">
        <input type="submit" value="Отправить" class="info-form__button" data-bind="click: send">
    </div>
</div>

