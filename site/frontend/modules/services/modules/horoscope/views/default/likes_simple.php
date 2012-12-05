<?php
/**
 * @var $model Horoscope
 */
?><?php
$url = $model->getUrl(true);

Yii::app()->clientScript
    ->registerScriptFile('http://vk.com/js/api/share.js?11')
    ->registerCssFile('http://stg.odnoklassniki.ru/share/odkl_share.css')
    ->registerScriptFile('http://stg.odnoklassniki.ru/share/odkl_share.js')
    ->registerMetaTag($this->title, null, null, array('property' => 'og:title'))
    ->registerMetaTag('/images/widget/horoscope/' . $model->zodiac . '.png', null, null, array('property' => 'og:image'))
    ->registerMetaTag($model->getMetaDescription(), null, null, array('property' => 'og:description'))
    ->registerMetaTag('article', null, null, array('property' => 'og:type'))
    ->registerMetaTag('Веселый Жираф', 'og:site_name');

$basePath = Yii::getPathOfAlias('site.frontend.widgets.socialLike.assets');
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/social.js');
?>
<div class="dates">Вам понравился гороскоп <?=$model->getName() ?>?</div>
<div class="like-block fast-like-block">
    <div class="box-1">

        <div class="share_button" style="width: 250px;">
            <a target="_blank" class="mrc__plugin_uber_like_button" href="http://connect.mail.ru/share?url=<?=urlencode($url) ?>"
               data-mrc-config="{'cm' : '1', 'ck' : '1', 'sz' : '20', 'st' : '1', 'tp' : 'combo'}">Нравится</a>
            <script src="http://cdn.connect.mail.ru/js/loader.js" type="text/javascript" charset="UTF-8"></script>
        </div>

        <div class="share_button">
            <div class="fb-custom-like">
                <?=HHtml::link('<i class="icon-fb"></i>Мне нравится',
                'http://www.facebook.com/sharer/sharer.php?u=' . urlencode($url),
                array('class' => 'fb-custom-text', 'onclick' => 'return Social.showFacebookPopup(this);'), true) ?>
                <div class="fb-custom-share-count">0</div>
                <script type="text/javascript">
                    $.getJSON("http://graph.facebook.com", { id:document.location.href }, function (json) {
                        $('.fb-custom-share-count').html(json.shares || '0');
                    });
                </script>
            </div>
        </div>

        <div class="share_button">
            <script type="text/javascript"><!--
                    document.write(VK.Share.button({url:'<?=$url ?>'},{type: "round", text: "Мне нравится"}));
            --></script>
        </div>

    </div>

</div>