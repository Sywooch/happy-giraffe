<?php
Yii::app()->clientScript
    ->registerScriptFile('http://vk.com/js/api/share.js?11')
    //->registerScript('vk-init', "VK.init({apiId: " . Yii::app()->params['social']['vk']['api_id'] . ", onlyWidgets: true});", CClientScript::POS_HEAD)
    ->registerCssFile('http://stg.odnoklassniki.ru/share/odkl_share.css')
    ->registerScriptFile('http://stg.odnoklassniki.ru/share/odkl_share.js')
    ->registerMetaTag($this->options['title'], 'og:title')//, null, array('property'=>'og:title'))
    ->registerMetaTag($this->options['image'], 'og:image')//, null, array('property'=>'og:image'))
    ->registerMetaTag($this->options['description'], 'og:description')//, null, array('property'=>'og:description'))
    ->registerMetaTag('article', 'og:type')//, null, array('property'=>'og:type') )
    ->registerMetaTag('Веселый Жираф', 'og:site_name')
    ->registerCss('vk_css', '#vk_like{width: 170px !important;}')
;
?>
<div class="like-block fast-like-block">

    <div class="box-1">
        <div class="clearfix">
            <table width="100%">
                <tr>
                    <td style="vertical-align:top;padding-right:35px;text-align: left;">
                        <iframe src="http://www.facebook.com/plugins/like.php?locale=ru_RU&amp;href=<?=urlencode('http://www.'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]) ?>&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
                    </td>
                    <td style="vertical-align:top;width: 150px;">
                        <script type="text/javascript"><!--
                        document.write(VK.Share.button(false,{type: "round", text: "Сохранить"}));
                        --></script>
                    </td>
                    <td style="vertical-align:top;padding-right:35px;text-align: left;">
                        <a class="odkl-klass-oc"
                           href="http://www.<?= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"] ?>"
                           onclick="ODKL.Share(this);return false;"><span>0</span></a>
                    </td>
                    <td style="vertical-align:top;">
                        <a href="https://twitter.com/share" class="twitter-share-button" data-lang="en">Твитнуть</a>
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