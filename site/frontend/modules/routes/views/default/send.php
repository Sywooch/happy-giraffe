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
            <span class="custom-like_icon odnoklassniki"></span>
        </a>
        <a href="http://vkontakte.ru/share.php?url=<?=$url?>" class="custom-like-small" onclick="return openPopup(this);">
            <span class="custom-like_icon vkontakte"></span>
        </a>

        <a href="http://www.facebook.com/sharer/sharer.php?u=<?=urlencode($url)?>" class="custom-like-small" onclick="return openPopup(this);">
            <span class="custom-like_icon facebook"></span>
        </a>

        <a href="https://twitter.com/share?url=<?=$url?>" class="custom-like-small" onclick="return openPopup(this);">
            <span class="custom-like_icon twitter"></span>
        </a>

        <div class="display-ib position-rel">

            <a href="javascript:;" class="custom-like-small" onclick="$('#email-popup').toggle();">
                <span class="custom-like_icon mail"></span>
            </a>

            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'send-route-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'action' => '',
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => false,
                    'validateOnType' => false,
                    'validationUrl' => $this->createUrl('/routes/default/sendEmail'),
                    'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    SendRoute();
                                return false;
                              }",
                )));
            $model = new SendRoute;
            $model->route_id = $route->id;
            ?>
            <div id="email-popup" class="custom-likes-b-popup" style="display:none;">

                <?=$form->hiddenField($model, 'route_id'); ?>

                <div class="custom-likes-b-popup_t">Отправить маршрут другу</div>

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

                <div class="clearfix margin-b10">
                    <?=$form->textArea($model, 'message', array('class' => 'custom-likes-b-popup_textarea itx-gray','placeholder'=>'Добавить сообщение')); ?>
                </div>
                <div class="clearfix textalign-r">
                    <button class="custom-like-small-popup_btn btn-gray-light margin-r5" onclick="$('#email-popup').toggle();return false;">Отменить</button>
                    <button class="custom-like-small-popup_btn btn-green">Отправить</button>
                </div>

                <div id="send-success" class="custom-likes-b-popup_win" style="display: none;">
                    <div class="custom-likes-b-popup_win-tx">
                        Письмо отправлено
                    </div>
                </div>

            </div>
            <?php $this->endWidget(); ?>

        </div>

    </div>
    <div class="map-route-share_tx">Ссылка на этот маршрут:</div>
    <div class="link-box">
        <a href="<?=$route->getUrl() ?>"
           class="link-box_a"><?=$route->getUrl(true) ?></a>
    </div>
</div>

<script type="text/javascript">
    function SendRoute() {
        $.post('/auto/routes/sendEmail/', $('#send-route-form').serialize(), function (response) {
            if (response.status) {
                $('#send-success').show();

                setTimeout(function() {
                    $('#send-success').hide();
                    $('#SendRoute_friend_email').val('');
                }, 2000)
            }
        }, 'json');
    }
</script>