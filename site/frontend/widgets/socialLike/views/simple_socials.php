<?php
/**
 * Author: alexk984
 * Date: 10.12.12
 */
if (empty($this->url))
    $url = 'http://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
else
    $url = $this->url;

$js = "$('.vk_share_button').html(VK.Share.button(document.location.href,{type: 'round', text: 'Мне нравится'}));";

Yii::app()->clientScript
    ->registerScriptFile('http://vk.com/js/api/share.js?11')
    ->registerMetaTag($this->options['title'], null, null, array('property' => 'og:title'))
    ->registerMetaTag($this->options['image'], null, null, array('property' => 'og:image'))
    ->registerMetaTag($this->options['description'], null, null, array('property' => 'og:description'))
    ->registerMetaTag('article', null, null, array('property' => 'og:type'))
    ->registerMetaTag('Веселый Жираф', 'og:site_name')
    ->registerScript('vklike', $js);
;
?>
<div class="like-block fast-like-block">
    <div class="box-1">

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
            <div class="vk_share_button"></div>
        </div>

        <div class="share_button">
            <div id="ok_shareWidget"></div>
            <script>
                !function (d, id, did, st) {
                    var js = d.createElement("script");
                    js.src = "http://connect.ok.ru/connect.js";
                    js.onload = js.onreadystatechange = function () {
                        if (!this.readyState || this.readyState == "loaded" || this.readyState == "complete") {
                            if (!this.executed) {
                                this.executed = true;
                                setTimeout(function () {
                                    OK.CONNECT.insertShareWidget(id,did,st);
                                }, 0);
                            }
                        }};
                    d.documentElement.appendChild(js);
                }(document,"ok_shareWidget","<?=$url ?>","{width:145,height:35,st:'straight',sz:20,ck:1}");
            </script>
        </div>

        <div class="share_button">
            <div class="tw_share_button">
                <a href="https://twitter.com/share" class="twitter-share-button" data-lang="ru" data-url="<?=$url?>">Твитнуть</a>
                <script type="text/javascript" charset="utf-8">
                    if (typeof twttr == 'undefined')
                        window.twttr = (function (d, s, id) {
                            var t, js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id)) return;
                            js = d.createElement(s);
                            js.id = id;
                            js.src = "//platform.twitter.com/widgets.js";
                            fjs.parentNode.insertBefore(js, fjs);
                            return window.twttr || (t = { _e:[], ready:function (f) {
                                t._e.push(f)
                            } });
                        }(document, "script", "twitter-wjs"));
                </script>
            </div>
        </div>
        <script type="text/javascript">
            $(function () {
                //подписываемся на клик
                if (VK && VK.Share && VK.Share.click) {
                    var oldShareClick = VK.Share.click;
                    VK.Share.click = function (index, el) {
                        Social.updateLikesCount('vk');
                        return oldShareClick.call(VK.Share, index, el);
                    }
                }

                twttr.ready(function (twttr) {
                    twttr.events.bind('tweet', function (event) {
                        console.log('tweet');
                        Social.updateLikesCount("tw")
                    });
                });
            });
        </script>
    </div>
</div>