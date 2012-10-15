<?php
    if (get_class($this->model) == 'ContestWork') {
        $attach = AttachPhoto::model()->findByEntity('ContestWork', $this->model->id);
        $photo = $attach[0]->photo;
        $url = Yii::app()->createAbsoluteUrl('albums/singlePhoto', array('entity' => 'Contest', 'photo_id' => $photo->id));
    } else {
        $url = 'http://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }

$js = "
    document.getElementById('vk_share_button').innerHTML = VK.Share.button(false,{type: 'round', text: 'Мне нравится'});
";

Yii::app()->clientScript
    //->registerScriptFile('http://vk.com/js/api/share.js?11')
    //->registerScript('vk-init', "VK.init({apiId: " . Yii::app()->params['social']['vk']['api_id'] . ", onlyWidgets: true});", CClientScript::POS_HEAD)
    ->registerCssFile('http://stg.odnoklassniki.ru/share/odkl_share.css')
    ->registerScriptFile('http://stg.odnoklassniki.ru/share/odkl_share.js')
    ->registerMetaTag($this->options['title'], null, null, array('property'=>'og:title'))
    ->registerMetaTag($this->options['image'], null, null, array('property'=>'og:image'))
    ->registerMetaTag($this->options['description'], null, null, array('property'=>'og:description'))
    ->registerMetaTag('article', null, null, array('property'=>'og:type') )
    ->registerMetaTag('Веселый Жираф', 'og:site_name')
    ->registerCss('vk_css', '#vk_like{width: 170px !important;}')
    ->registerScript('vklike', $js);
;
?>
<div class="like-block fast-like-block">

    <div class="box-1">
        <div class="clearfix">
            <table width="100%">
                <tr>
                    <td style="vertical-align:top;padding-right:0;text-align: left;">
                        <iframe src="//www.facebook.com/plugins/like.php?locale=ru_RU&amp;href=<?=urlencode($url) ?>&amp;send=false&amp;layout=button_count&amp;width=150&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:150px; height:21px;" allowTransparency="true"></iframe>
                    </td>
                    <td style="vertical-align:top;width: 150px;" id="vk_share_button">

                    </td>
                    <td style="vertical-align:top;padding-right:15px;text-align: left;">
                        <a class="odkl-klass-oc"
                           href="<?=$url?>"
                           onclick="ODKL.Share(this);return false;"><span>0</span></a>
                    </td>
                    <td style="vertical-align:top;">
                        <?=HHtml::link('Tweet', 'https://twitter.com/share', array('class'=>'twitter-share-button', 'data-lang'=>'en'), true) ?>
                        <script>!function (d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (!d.getElementById(id)) {
                                js = d.createElement(s);
                                js.id = id;
                                js.src = "//platform.twitter.com/widgets.js";
                                fjs.parentNode.insertBefore(js, fjs);
                            }
                        }(document, "script", "twitter-wjs");</script>
                    </td>
                </tr>
            </table>
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