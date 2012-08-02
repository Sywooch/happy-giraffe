<?php
Yii::app()->clientScript
    ->registerScriptFile('http://vk.com/js/api/share.js?11')
    //->registerScript('vk-init', "VK.init({apiId: " . Yii::app()->params['social']['vk']['api_id'] . ", onlyWidgets: true});", CClientScript::POS_HEAD)
    ->registerCssFile('http://stg.odnoklassniki.ru/share/odkl_share.css')
    ->registerScriptFile('http://stg.odnoklassniki.ru/share/odkl_share.js')
    ->registerMetaTag($this->options['title'], null, null, array('property'=>'og:title'))
    ->registerMetaTag($this->options['image'], null, null, array('property'=>'og:image'))
    ->registerMetaTag($this->options['description'], null, null, array('property'=>'og:description'))
    ->registerMetaTag('article', null, null, array('property'=>'og:type') )
    ->registerMetaTag('Веселый Жираф', 'og:site_name')
    ->registerCss('vk_css', '#vk_like{width: 170px !important;}')
;
?>
<div class="like-block fast-like-block">

    <div class="box-1">
        <div class="clearfix">
            <table width="100%">
                <tr>
                    <td style="vertical-align:top;padding-right:0;text-align: left;">
                        <iframe src="//www.facebook.com/plugins/like.php?locale=ru_RU&amp;href=<?=urlencode('http://www.'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]) ?>&amp;send=false&amp;layout=button_count&amp;width=150&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:150px; height:21px;" allowTransparency="true"></iframe>
                    </td>
                    <td style="vertical-align:top;width: 150px;">
                        <script type="text/javascript"><!--
                        document.write(VK.Share.button(false,{type: "round", text: "Мне нравится"}));
                        --></script>
                    </td>
                    <td style="vertical-align:top;padding-right:15px;text-align: left;">
                        <a class="odkl-klass-oc"
                           href="http://<?= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"] ?>"
                           onclick="ODKL.Share(this);return false;"><span>0</span></a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>