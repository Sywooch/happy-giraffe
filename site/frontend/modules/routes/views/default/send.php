<?php
/**
 * Author: alexk984
 * Date: 20.02.13
 * @var $route Route
 * @var $texts array
 */

Yii::app()->clientScript
    ->registerMetaTag($texts[0], null, null, array('property' => 'og:title'))
    ->registerMetaTag('/images/services/map-route/map-route-desc-3.jpg', null, null, array('property' => 'og:image'))
    ->registerMetaTag($texts[1], null, null, array('property' => 'og:description'));


$url = $route->getUrl(true);
?>
<div class="map-route-share">
    <div class="map-route-share_tx"><?=$texts[7] ?></div>
    <div class="custom-likes-small">
        <a href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=<?=$url?>" class="custom-like-small" onclick="return openPopup(this);">
            <span class="custom-like-small_icon odkl"></span>
        </a>
        <a href="http://connect.mail.ru/share?url=<?=$url?>" class="custom-like-small" onclick="return openPopup(this);">
            <span class="custom-like-small_icon mailru"></span>
        </a>

        <a href="http://vkontakte.ru/share.php?url=<?=$url?>" class="custom-like-small" onclick="return openPopup(this);">
            <span class="custom-like-small_icon vk"></span>
        </a>

        <a href="http://www.facebook.com/sharer/sharer.php?u=<?=urlencode($url)?>" class="custom-like-small" onclick="return openPopup(this);">
            <span class="custom-like-small_icon fb"></span>
        </a>
        <a href="javascript:;" class="custom-like-small" onclick="$('#email-popup').toggle();">
            <span class="custom-like-small_icon mail"></span>
        </a>

        <div id="email-popup" class="custom-like-small-popup">
            <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'send-route-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'action' => '',
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnChange' => false,
                'validateOnType' => false,
                'validationUrl' => $this->createUrl('/route/default/sendEmail'),
                'afterValidate' => "js:function(form, data, hasError) {
                            if (!hasError)
                                SendRoute();
                            return false;
                          }",
            ))); ?>
            <?php $model = new SendRoute;
            $model->route_id = $route->id;
            ?>
            <?=$form->hiddenField($model, 'route_id'); ?>

            <div class="custom-like-small-popup_t">Отправить маршрут другу</div>

            <?php if (Yii::app()->user->isGuest):?>
            <div class="clearfix margin-b10">
                <?=$form->textField($model, 'own_email', array('class' => 'custom-like-small-popup_it itx-bluelight','placeholder'=>'Свой email')); ?>
                <?=$form->error($model, 'own_email'); ?>
            </div>
            <?php endif ?>

            <div class="clearfix margin-b10">
                <?=$form->textField($model, 'friend_email', array('class' => 'custom-like-small-popup_it itx-bluelight','placeholder'=>'Email друга')); ?>
                <?=$form->error($model, 'friend_email'); ?>
            </div>

            <?if(CCaptcha::checkRequirements() && Yii::app()->user->isGuest):?>
            <div class="clearfix margin-b10">
                <?$this->widget('CCaptcha', array('showRefreshButton'=>false,'clickableImage'=>true))?>
                <?=CHtml::activeTextField($model, 'verifyCode', array(
                'class'=>'custom-like-small-popup_it itx-bluelight',
                'placeholder'=>'Введите знаки с картинки'
            ))?>
                <?=$form->error($model, 'verifyCode'); ?>
            </div>
            <?endif ?>
            <button class="custom-like-small-popup_btn btn-green btn-medium">Отправить</button>

            <?php $this->endWidget(); ?>

            <div id="send-success" style="display: none">Маршрут успешно отправлен!</div>
        </div>
    </div>
    <div class="map-route-share_tx">Ссылка на этот маршрут:</div>
    <div class="link-box">
        <a href="<?=$route->url ?>"
           class="link-box_a"><?=$route->getUrl(true) ?></a>
    </div>
</div>