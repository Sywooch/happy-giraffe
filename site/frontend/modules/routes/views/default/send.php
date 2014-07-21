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
    </div>
</div>