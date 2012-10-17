<?php
if (get_class($this->model) == 'ContestWork' && Yii::app()->request->isAjaxRequest) {
    $attach = AttachPhoto::model()->findByEntity('ContestWork', $this->model->id);
    $photo = $attach[0]->photo;
    $url = Yii::app()->createAbsoluteUrl('albums/singlePhoto', array('entity' => 'Contest', 'contest_id' => $this->model->contest_id, 'photo_id' => $photo->id));
} else {
    $url = 'http://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
}

$js = "
    $('.vk_share_button').html(VK.Share.button(document.location.href,{type: 'round', text: 'Мне нравится'}));
";

Yii::app()->clientScript
    ->registerScriptFile('http://vk.com/js/api/share.js?11')
    //->registerScript('vk-init', "VK.init({apiId: " . Yii::app()->params['social']['vk']['api_id'] . ", onlyWidgets: true});", CClientScript::POS_HEAD)
    ->registerCssFile('http://stg.odnoklassniki.ru/share/odkl_share.css')
    ->registerScriptFile('http://stg.odnoklassniki.ru/share/odkl_share.js')
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
        <div class="clearfix">
            <table width="100%">
                <tr>
                    <td style="vertical-align:top;padding-right:0;text-align: left;">
                        <div class="fb-custom-like">
                            <a href="http://www.facebook.com/sharer/sharer.php?u=<?=urlencode($url) ?>"
                               onclick="return Social.showFacebookPopup(this);" class="fb-custom-text">
                                <i class="pluginButtonIcon img sp_like sx_like_fav"></i>Мне нравится</a>
                            <div class="fb-custom-share-count">0</div>
                            <script type="text/javascript">
                                $.getJSON("http://graph.facebook.com", { id : document.location.href }, function(json){
                                    $('.fb-custom-share-count').html(json.shares || '0');
                                });
                            </script>
                        </div>
                    </td>
                    <td style="vertical-align:top;width: 150px;" class="vk_share_button">

                    </td>
                    <td style="vertical-align:top;padding-right:15px;text-align: left;">
                        <a class="odkl-klass-oc"
                           href="<?=$url?>"
                           onclick="console.log('test'); ODKL.Share(this);return false;"><span>0</span></a>
                    </td>
                    <td style="vertical-align:top;" class="tw_share_button">
                        <a href="https://twitter.com/share" class="twitter-share-button" data-lang="ru" data-url="<?=$url?>">Твитнуть</a>
                        <script type="text/javascript" charset="utf-8">
                                if (typeof twttr == 'undefined')
                                    window.twttr = (function (d,s,id) {
                                        var t, js, fjs = d.getElementsByTagName(s)[0];
                                        if (d.getElementById(id)) return; js=d.createElement(s); js.id=id;
                                        js.src="//platform.twitter.com/widgets.js"; fjs.parentNode.insertBefore(js, fjs);
                                        return window.twttr || (t = { _e: [], ready: function(f){ t._e.push(f) } });
                                    }(document, "script", "twitter-wjs"));
                        </script>
                    </td>
                </tr>
            </table>
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

    <div class="box-2">

        <?php
        $this->render('_yh_min', array(
            'options' => $this->providers['yh'],
        ));
        ?>
    </div>

    <div class="box-3">
        <div class="rating"><span><?php echo Rating::model()->countByEntity($this->model, false) ?></span></div>
        <?php if ($this->notice != ''): ?>
        <div class="icon-info">
            <div class="tip">
                <?php echo $this->notice; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

</div>