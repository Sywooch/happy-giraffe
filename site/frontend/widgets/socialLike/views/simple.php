<?php
Yii::app()->clientScript
    ->registerScriptFile('http://vk.com/js/api/share.js?11')
    //->registerScript('vk-init', "VK.init({apiId: " . Yii::app()->params['social']['vk']['api_id'] . ", onlyWidgets: true});", CClientScript::POS_HEAD)
    ->registerCssFile('http://stg.odnoklassniki.ru/share/odkl_share.css')
    ->registerScriptFile('http://stg.odnoklassniki.ru/share/odkl_share.js')
    ->registerScript('ODKL.init', 'ODKL.init();', CClientScript::POS_READY)
    ->registerMetaTag($this->options['title'], 'og:title')
    ->registerMetaTag($this->options['image'], 'og:image')
    ->registerMetaTag($this->options['description'], 'og:description')
    ->registerMetaTag('article', 'og:type')
    ->registerMetaTag('Веселый Жираф', 'og:site_name')
    ->registerCss('vk_css', '#vk_like{width: 170px !important;}')
;
?>
<div class="like-block fast-like-block">

    <div class="box-1">
        <div id="fb-root"></div>
        <script>(function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

        <div class="clearfix">
            <table width="100%">
                <tr>
                    <td style="vertical-align:top;width: 150px;text-align: left;">
                        <div class="fb-like" data-send="false" data-layout="button_count" data-width="50"
                             data-show-faces="true"></div>
                    </td>
                    <td style="vertical-align:top;width: 150px;">
                        <script type="text/javascript"><!--
                        document.write(VK.Share.button(false,{type: "round", text: "Сохранить"}));
                        --></script>
                    </td>
                    <td style="vertical-align:top;width: 120px;text-align: left;">
                        <a class="odkl-klass-oc"
                           href="http://www.<?= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"] ?>"
                           onclick="ODKL.Share(this);return false;"><span>0</span></a>
                    </td>
                    <td style="vertical-align:top;width: 120px;">
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