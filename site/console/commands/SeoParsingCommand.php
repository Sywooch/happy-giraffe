<?php
/**
 * Author: alexk984
 * Date: 13.03.12
 */

Yii::import('site.seo.models.*');
Yii::import('site.seo.models.mongo.*');
Yii::import('site.common.models.mongo.*');
Yii::import('site.seo.components.*');
Yii::import('site.seo.modules.competitors.models.*');
Yii::import('site.seo.modules.writing.models.*');
Yii::import('site.seo.modules.promotion.models.*');
Yii::import('site.seo.modules.traffic.models.*');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
Yii::import('site.frontend.helpers.*');

class SeoParsingCommand extends CConsoleCommand
{
    public function beforeAction($action)
    {
        Yii::import('site.seo.modules.competitors.components.*');

        return true;
    }

    public function actionWordstat($mode = 0)
    {
        $parser = new WordstatParser();
        $parser->start($mode);
    }

    public function actionWordstatSeason($mode = 0)
    {
        $parser = new WordstatSeasonParser();
        $parser->use_proxy = false;
        $parser->start($mode);
    }

    public function actionWordstatSeasonTest()
    {
        $parser = new WordstatSeasonParser();
        $parser->debug = 1;
        $parser->keyword = YandexPopularity::model()->findByPk(2);
        $html = <<<EOD
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="keywords" content="Подбор слов, wordstat, вордстат, статистика запросов яндекс, подбор ключевых слов, статистика ключевых слов яндекс"/>
<meta name="description" content="Подбор слов Яндекса - это сервис для оценки пользовательского интереса к конкретным тематикам и для подбора ключевых слов рекламодателями Яндекс.Директа. Сервис содержит подробную статистику запросов к Яндексу за последние 30 дней."/>
<title>Статистика ключевых слов на Яндексе:&nbsp;отеки при беременности лечение форум</title>
<link rel="Stylesheet" href="http://css.yandex.ru/css/_yandex-global.css" /><link rel="shortcut icon" href="/favicon.ico">    <script type="text/javascript" charset="utf-8" src="//yandex.st/jquery/1.4.2/jquery.min.js"></script><script type="text/javascript" charset="utf-8" src="//yandex.st/lego/2.3-54/common/js/_common.js"></script><script type="text/javascript">//<!--
Lego.init({
    login: '',
    locale: 'ru',
    id: 'advq',
    'lego-static-host': '\/\/yandex.st\/lego\/2.3-54',
    'passport-msg': '',
    retpath: '',
    index: '0'
});
//--></script><!--[if gt IE 7]><!--><link rel="Stylesheet" href="/css/_advq.css"/><!--<![endif]-->
<!--[if lt IE 8]><link rel="Stylesheet" href="/css/_advq.ie.css"/><![endif]-->
<link rel="SHORTCUT ICON" type="image/x-icon" href="/favicon.ico">
<script type="text/javascript" src='/js/_advq.js' charset="utf-8"></script>
<style type="text/css">
    td
    {
        padding: 0px;
    }
</style>

<script type="text/javascript">
function _onLoad() {
  if (window.name == 'advq') {
      var refs = $.merge($('.b-head-tabs__link'), $('.b-head-userinfo__link'));
      for(var i = 0; i < refs.length; i++) {
              (function(ref) {
                ref.onclick = function() {
                    var wnd = window.open(ref.href);
                    wnd.focus();
                    return false;
                };
             })(refs[i]);
      };
  } else {
      var add_banner_block = document.getElementById('add_banner_block');
      if (add_banner_block) {
          add_banner_block.style.display = '';
      }
  }
}
</script></head>

<body bgcolor="white" link="#0000cc" marginheight="0" marginwidth="0" topmargin="0" rightmargin="0" bottommargin="0" leftmargin="0" onload="_onLoad()">
<iframe frameBorder="0" src="http://kiks.yandex.ru/su/" style="width:40px;height:40px;overflow:hidden;position:absolute;left:-40px;top:0;opacity:0"></iframe>

<!-- Yandex.Metrika -->
<script src="//mc.yandex.ru/resource/watch.js" type="text/javascript"></script>
<script type="text/javascript">
try { var yaCounter292098 = new Ya.Metrika(292098); } catch(e){}
</script>
<noscript><div style="position: absolute;"><img src="//mc.yandex.ru/watch/292098" alt="" /></div></noscript>
<!-- /Yandex.Metrika -->
<table class="l-head"><tr>    <td class="l-head__g"><i class="l-head__gap" style="background:url(//www.tns-counter.ru/V13a****yandex_ru/ru/CP1251/tmsec=yandex_advq/0"></i></td>    <td class="l-head__l"><div class="b-head-logo"><div class="b-head-logo__logo"><a href="http://www.yandex.ru" class="b-head-logo__link"><img class="b-head-logo__img" border="0" alt="Яндекс" src="http://yandex.st/lego/_/X31pO5JJJKEifJ7sfvuf3mGeD_8.png"></a>    </div>
</div>    </td>    <td class="l-head__gl"><i class="l-head__gap"></i></td>    <td class="l-head__c"><!-- noindex --><table class="b-head-tabs g-js" onclick="return {name: 'b-head-tabs', 'default': ''}">    <tr>

        <td class="b-head-tabs__item b-head-tabs__tab"><a href="http://stat.yandex.ru" class="b-head-tabs__link" onclick="yaCounter292098.reachGoal('REF-STAT');">Статистика посещений</a>        </td>    </tr></table><!-- /noindex -->    <div class="b-head-line"><strong class="b-head-name">статистика ключевых слов</strong>    </div>    <table cellpadding="4" cellspacing="0" border="0" class="b-menu" style="float: left;">
        <tbody>
            <tr valign="bottom">        <td  class="b-menu__menu-item b-menu__menu-item-first" ><a href="?scmd=abs&amp;cmd=words&amp;t=%D0%BE%D1%82%D0%B5%D0%BA%D0%B8%20%D0%BF%D1%80%D0%B8%20%D0%B1%D0%B5%D1%80%D0%B5%D0%BC%D0%B5%D0%BD%D0%BD%D0%BE%D1%81%D1%82%D0%B8%20%D0%BB%D0%B5%D1%87%D0%B5%D0%BD%D0%B8%D0%B5%20%D1%84%D0%BE%D1%80%D1%83%D0%BC">по словам</a></td>        <td  class="b-menu__menu-item " ><a href="?scmd=abs&amp;cmd=regions&amp;t=%D0%BE%D1%82%D0%B5%D0%BA%D0%B8%20%D0%BF%D1%80%D0%B8%20%D0%B1%D0%B5%D1%80%D0%B5%D0%BC%D0%B5%D0%BD%D0%BD%D0%BE%D1%81%D1%82%D0%B8%20%D0%BB%D0%B5%D1%87%D0%B5%D0%BD%D0%B8%D0%B5%20%D1%84%D0%BE%D1%80%D1%83%D0%BC">по регионам</a></td>        <td  class="b-menu__menu-item " ><a href="?scmd=abs&amp;cmd=maps&amp;t=%D0%BE%D1%82%D0%B5%D0%BA%D0%B8%20%D0%BF%D1%80%D0%B8%20%D0%B1%D0%B5%D1%80%D0%B5%D0%BC%D0%B5%D0%BD%D0%BD%D0%BE%D1%81%D1%82%D0%B8%20%D0%BB%D0%B5%D1%87%D0%B5%D0%BD%D0%B8%D0%B5%20%D1%84%D0%BE%D1%80%D1%83%D0%BC">на карте</a></td>
            </tr>
        </tbody>
    </table>
    <table cellpadding="4" cellspacing="0" border="0" class="b-menu" style="float: left;">
        <tbody>
            <tr valign="bottom">
        <td class="active b-menu__menu-item-active b-menu__menu-item ">по месяцам</td>        <td  class="b-menu__menu-item " ><a href="?scmd=abs&amp;cmd=weeks&amp;t=%D0%BE%D1%82%D0%B5%D0%BA%D0%B8%20%D0%BF%D1%80%D0%B8%20%D0%B1%D0%B5%D1%80%D0%B5%D0%BC%D0%B5%D0%BD%D0%BD%D0%BE%D1%81%D1%82%D0%B8%20%D0%BB%D0%B5%D1%87%D0%B5%D0%BD%D0%B8%D0%B5%20%D1%84%D0%BE%D1%80%D1%83%D0%BC">по неделям</a></td>            </tr>
        </tbody>
    </table>     </td>    <td class="l-head__gr"><i class="l-head__gap"></i></td>    <td class="l-head__r"><div class="b-head-userinfo__help"><a class="b-head-userinfo__link" href="http://help.yandex.ru/advq/?id=658869" onclick="yaCounter292098.reachGoal('REF-HELP');">&zwnj;</a></div>    </td>    <td class="l-head__g"><i class="l-head__gap"></i></td></tr></table><form name="ad" method=get action="?" onsubmit="if (document.getElementById('text').value.length > 2000) {alert('Слишком длинный запрос'); return false}">
  <input type="hidden" name="cmd" value="months">
  <input type="hidden" name="scmd" value=abs>
  <table  class="l-page l-page_layout_12-60-16" style="border-collapse: collapse; width: 100%; "  cellpadding="0" cellspacing="0"  border="0"><tbody style="font-size: 100%;">            <tr><td colspan="7">&nbsp;</td></tr>        <tr>
            <td class="l-page__gap"><i/></td>
            <td class="l-page__left" style="text-align: right;">
                <div style=" line-height: 1px; "></div>Ключевые слова:            </td>
            <td class="l-page__gap-left"><i style="width:3.1em"/></td>
            <td class="l-page__center" >
                <div style="width: 17.5em; line-height: 1px; margin: 0px; padding: 0px; height: 1px;"></div>            <input id="text" type="text" value="отеки при беременности лечение форум" name="t" style="width: 100%;">            </td>
            <td class="l-page__gap-left"><i/></td>
            <td class="l-page__right">
                <div style="width: 0.5em; line-height: 1px; "></div>            </td>
            <td class="l-page__gap"><i/></td>
        </tr>    </tbody>
    <tbody id="geoblock" class="g-js" onclick="return {name: 'b-region-selector', 'path': 'regions_ru.html'}">
        <tr>
            <td class="l-page__gap">&nbsp;</td>
            <td class="l-page__left" style="text-align: right;">Регионы <br>
              <strong><a href="#" class="b-region-selector-change-geo" onclick="yaCounter292098.reachGoal('REF-REGION');">Уточнить регион&hellip;</a></strong>

            </td>
            <td class="l-page__gap-left"><i style="width:3.1em"/></td>
            <td class="l-page__center" style="padding: 0.5em 0;">
                <div style="font-weight: bold" class="b-region-selector-text-string">Россия, СНГ (исключая Россию), Европа, Азия, Африка, Северная Америка, Южная Америка, Австралия и Океания</div>
                <input type="hidden" name="geo" value="" class="b-region-selector-geo-hidden"/>
                <input type="hidden" name="text_geo" id="text_geo" class="b-region-selector-geo-hidden-text" value=""/>
                <div id="cleargeo" class="label help">
                    <a href="#" class="b-region-selector-clear-geo hidden">отменить выбранные регионы</a>
                </div>
            </td>
            <td class="l-page__gap-left"><i/></td>
            <td class="l-page__right">&nbsp;</td>
            <td class="l-page__gap"><i/></td>
        </tr>
        <!--<tr><td colspan="7">&nbsp;</td></tr>-->
     </tbody>


    <script type="text/javascript">

        showGeo = function(bid, regions_id, regions_name) {
            $(document).triggerHandler('change-geo', {'bid': bid, 'regions_id': regions_id, 'regions_name': regions_name})
        }
    </script><tbody style="font-size: 100%;">        <tr>
            <td class="l-page__gap"><i/></td>
            <td class="l-page__left" style="text-align: right;">
                <div style=" line-height: 1px; "></div>            </td>
            <td class="l-page__gap-left"><i style="width:3.1em"/></td>
            <td class="l-page__center" >
                <div style="width: 17.5em; line-height: 1px; margin: 0px; padding: 0px; height: 1px;"></div>        <input type="submit" value="Показать" onclick="yaCounter292098.reachGoal('BUT-SELMON');">            </td>
            <td class="l-page__gap-left"><i/></td>
            <td class="l-page__right">
                <div style="width: 0.5em; line-height: 1px; "></div>            </td>
            <td class="l-page__gap"><i/></td>
        </tr>            <tr><td colspan="7">&nbsp;</td></tr>    </tbody><tbody style="font-size: 100%;">        <tr>
            <td class="l-page__gap"><i/></td>
            <td class="l-page__left" style="text-align: right;">
                <div style=" line-height: 1px; "></div>Шкала графика:            </td>
            <td class="l-page__gap-left"><i style="width:3.1em"/></td>
            <td class="l-page__center" >
                <div style="width: 17.5em; line-height: 1px; margin: 0px; padding: 0px; height: 1px;"></div>            <table cellpadding="0" cellspacing="0" border="0" class="reportsTabs" style="margin-bottom:10px;">
              <tr>
        <td class="active">абсолютная</td>        <td><a href="?scmd=rel&amp;cmd=months&amp;t=%D0%BE%D1%82%D0%B5%D0%BA%D0%B8%20%D0%BF%D1%80%D0%B8%20%D0%B1%D0%B5%D1%80%D0%B5%D0%BC%D0%B5%D0%BD%D0%BD%D0%BE%D1%81%D1%82%D0%B8%20%D0%BB%D0%B5%D1%87%D0%B5%D0%BD%D0%B8%D0%B5%20%D1%84%D0%BE%D1%80%D1%83%D0%BC">относительная</a></td>              </tr>
            </table>            </td>
            <td class="l-page__gap-left"><i/></td>
            <td class="l-page__right">
                <div style="width: 0.5em; line-height: 1px; "></div>            </td>
            <td class="l-page__gap"><i/></td>
        </tr>    </tbody><tbody style="font-size: 100%;">        <tr>
            <td class="l-page__gap"><i/></td>
            <td class="l-page__left" style="text-align: right;">
                <div style=" line-height: 1px; "></div>            </td>
            <td class="l-page__gap-left"><i style="width:3.1em"/></td>
            <td class="l-page__center" >
                <div style="width: 17.5em; line-height: 1px; margin: 0px; padding: 0px; height: 1px;"></div>          <h4>Показов за последние 30 дней: 31, за период: 57</h4>
    <script type="text/javascript" src="/flash/amstock/swfobject.js"></script>

    <center><h2></h2></center>
    <div id="flashcontent_flchart">
        <strong><a href="http://get.adobe.com/flashplayer/">Для просмотра графиков установите последнюю версию Flash Player</a></strong>
    </div>

    <script type="text/javascript">
      // <![CDATA[
        var so = new SWFObject("/flash/amstock/amstock.swf", "flchart", "100%", "400px", "8", "#FFFFFF");
        so.addVariable("path", "/flash/amstock/");
        so.addVariable("loading_settings", "Инициализация");
        so.addVariable("loading_data", "Загрузка данных");
        so.addVariable("preloader_color", "#FFFFFF");
        so.addVariable("chart_settings", encodeURIComponent("<settings><margins>5</margins><equal_spacing>false</equal_spacing><max_grid_count>15</max_grid_count><start_on_axis>false</start_on_axis><js_enabled>false</js_enabled><redraw>true</redraw><data_sets><data_set><events_file_name>../../do?cmd=am_events</events_file_name><csv><separator>;</separator><date_format>YYYY-MM-DD</date_format><decimal_separator>.</decimal_separator><columns><column>date</column><column>count</column></columns><data>2011-01-31;0\n2011-02-28;0\n2011-03-31;0\n2011-04-30;0\n2011-05-31;0\n2011-06-30;0\n2011-07-31;0\n2011-08-31;0\n2011-09-30;0\n2011-10-31;0\n2011-11-30;0\n2011-12-31;0\n2012-01-31;0\n2012-02-29;0\n2012-03-31;3\n2012-04-30;10\n2012-05-31;1\n2012-06-30;5\n2012-07-31;0\n2012-08-31;14\n2012-09-30;0\n2012-10-31;0\n2012-11-30;0\n2012-12-31;24</data></csv></data_set></data_sets><charts><chart><legend><enabled>true</enabled><text_size>12</text_size><show_date>true</show_date></legend><values><y_left><min>0</min></y_left></values><graphs><graph><data_sources><close>count</close></data_sources><fill_alpha>0</fill_alpha><title>Количество</title><color>FF0000</color><type>line</type><legend><date key=\"true\" title=\"true\"><![CDATA[: {close}]]></date><period key=\"true\" title=\"true\"><![CDATA[: {sum}]]></period></legend></graph></graphs></chart></charts><data_set_selector><enabled>false</enabled></data_set_selector><period_selector><periods><period type=\"MM\" count=\"1\">1М</period><period type=\"MM\" count=\"3\">3М</period><period type=\"MM\" count=\"6\">6М</period><period type=\"YYYY\" count=\"1\">1Г</period><period selected=\"true\" type=\"MAX\">Вcё</period></periods><periods_title>Периоды:</periods_title><custom_period_title>Произвольный период:</custom_period_title></period_selector><header><enabled>false</enabled></header><context_menu><default_items><zoom>false</zoom><print>false</print></default_items></context_menu><scroller><enabled>true</enabled><graph_data_source>count</graph_data_source><playback><enabled>true</enabled><speed>3</speed></playback></scroller><date_formats><legend><weeks>month YYYY</weeks></legend></date_formats><strings><months><month>Янв</month><month>Фев</month><month>Мар</month><month>Апр</month><month>Май</month><month>Июн</month><month>Июл</month><month>Авг</month><month>Сен</month><month>Окт</month><month>Ноя</month><month>Дек</month></months><weekdays><day>Вс</day><day>Пн</day><day>Вт</day><day>Ср</day><day>Чт</day><day>Пт</day><day>Сб</day></weekdays></strings></settings>"));
        so.addVariable("key", "109-ec78d053068595facaeeb4129b3e7c55");

        so.write("flashcontent_flchart");
      // ]]>
    </script>          <br>
          <h4>Показы по месяцам</h4>          <table cellpadding=5 cellspacing=0 border=0 class="reports padding-5">              <tr class="tlist">                <td class="b" style="background-color: #CCCCCC;  border-top: 1px solid #999999;" nowrap="nowrap">01.01.2011
                  -
                  31.01.2011
                </td>
                <td class="b" nowrap="nowrap"  style="border-top: 1px solid #999999;">0</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>                <td class="b" style="background-color: #CCCCCC;  border-top: 1px solid #999999;" nowrap="nowrap">01.09.2011
                  -
                  30.09.2011
                </td>
                <td class="b" nowrap="nowrap"  style="border-top: 1px solid #999999;">0</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>                <td class="b" style="background-color: #CCCCCC;  border-top: 1px solid #999999;" nowrap="nowrap">01.05.2012
                  -
                  31.05.2012
                </td>
                <td class="b" nowrap="nowrap"  style="border-top: 1px solid #999999;">1</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>              <tr class="tlist">                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.02.2011
                  -
                  28.02.2011
                </td>
                <td class="b" nowrap="nowrap" >0</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.10.2011
                  -
                  31.10.2011
                </td>
                <td class="b" nowrap="nowrap" >0</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.06.2012
                  -
                  30.06.2012
                </td>
                <td class="b" nowrap="nowrap" >5</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>              <tr class="tlist">                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.03.2011
                  -
                  31.03.2011
                </td>
                <td class="b" nowrap="nowrap" >0</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.11.2011
                  -
                  30.11.2011
                </td>
                <td class="b" nowrap="nowrap" >0</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.07.2012
                  -
                  31.07.2012
                </td>
                <td class="b" nowrap="nowrap" >0</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>              <tr class="tlist">                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.04.2011
                  -
                  30.04.2011
                </td>
                <td class="b" nowrap="nowrap" >0</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.12.2011
                  -
                  31.12.2011
                </td>
                <td class="b" nowrap="nowrap" >0</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.08.2012
                  -
                  31.08.2012
                </td>
                <td class="b" nowrap="nowrap" >14</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>              <tr class="tlist">                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.05.2011
                  -
                  31.05.2011
                </td>
                <td class="b" nowrap="nowrap" >0</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.01.2012
                  -
                  31.01.2012
                </td>
                <td class="b" nowrap="nowrap" >0</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.09.2012
                  -
                  30.09.2012
                </td>
                <td class="b" nowrap="nowrap" >0</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>              <tr class="tlist">                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.06.2011
                  -
                  30.06.2011
                </td>
                <td class="b" nowrap="nowrap" >0</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.02.2012
                  -
                  29.02.2012
                </td>
                <td class="b" nowrap="nowrap" >0</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.10.2012
                  -
                  31.10.2012
                </td>
                <td class="b" nowrap="nowrap" >0</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>              <tr class="tlist">                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.07.2011
                  -
                  31.07.2011
                </td>
                <td class="b" nowrap="nowrap" >0</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.03.2012
                  -
                  31.03.2012
                </td>
                <td class="b" nowrap="nowrap" >3</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.11.2012
                  -
                  30.11.2012
                </td>
                <td class="b" nowrap="nowrap" >0</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>              <tr class="tlist">                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.08.2011
                  -
                  31.08.2011
                </td>
                <td class="b" nowrap="nowrap" >0</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.04.2012
                  -
                  30.04.2012
                </td>
                <td class="b" nowrap="nowrap" >10</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>                <td class="b" style="background-color: #CCCCCC; " nowrap="nowrap">01.12.2012
                  -
                  31.12.2012
                </td>
                <td class="b" nowrap="nowrap" >24</td>
                <td style="border-left: 1px solid #999999" bgcolor="FFFFFF">&nbsp;</td>            </table>            </td>
            <td class="l-page__gap-left"><i/></td>
            <td class="l-page__right">
                <div style="width: 0.5em; line-height: 1px; "></div>            </td>
            <td class="l-page__gap"><i/></td>
        </tr>    </tbody>  </table>

</form><div class="block-copyright">
<div class="copyright" style="float:right">
<nobr>&copy; 2013 <a href="http://www.yandex.ru">Яндекс</a></nobr>
</div>
</div>

<script type="text/javascript">
  var text = document.getElementById('text');
  if (text) {
	  text.focus();
  };
</script>
</body>
</html>
EOD;

        $parser->parseData($html);
    }

    public function actionRouteCheck(){
        $parser = new RouteChecker;
        $parser->start();
    }

    public function actionLi($site)
    {
        $last_parsed = SeoUserAttributes::getAttribute('last_li_parsed_'.date("Y-m") , 1);
        if (empty($site)) {
            $parser = new LiParser;

            if (!empty($last_parsed))
                $sites = Site::model()->findAll('id > '.$last_parsed.' AND type = 1');
            else
                $sites = Site::model()->findAll('type = 1');

            foreach ($sites as $site) {
                $parser->start($site->id, 2013, 1, 1);

                SeoUserAttributes::setAttribute('last_li_parsed_'.date("Y-m") , $site->id, 1);
            }
        } else {
            $parser = new LiParser;
            $parser->start($site, 2013, 1, 1);
        }
    }

    public function actionMailru($site)
    {
        $last_parsed = SeoUserAttributes::getAttribute('last_mailru_parsed_'.date("Y-m") , 1);
        if (empty($site)) {
            $parser = new MailruParser(false, true);

            if (!empty($last_parsed))
                $sites = Site::model()->findAll('id > '.$last_parsed.' AND type=2');
            else
                $sites = Site::model()->findAll('type=2');

            foreach ($sites as $site) {
                $parser->start($site->id, 2013, 1, 1);
                SeoUserAttributes::setAttribute('last_mailru_parsed_'.date("Y-m") , $site->id, 1);
            }
        } else {
            $parser = new MailruParser(false, true);
            $parser->start($site, 2013, 1, 1);
        }
    }

    public function actionLiKeywords($site){
        $last_parsed = SeoUserAttributes::getAttribute('last_li_parsed_'.date("Y-m-d") , 1);
        $parser = new LiKeywordsParser;

        if (empty($site)) {
            if (!empty($last_parsed))
                $sites = Site::model()->findAll('id > '.$last_parsed);
            else
                $sites = Site::model()->findAll();

            foreach ($sites as $site) {
                $parser->start($site->id);
                SeoUserAttributes::setAttribute('last_li_parsed_'.date("Y-m-d"), $site->id, 1);
            }
        } else {
            $parser = new LiKeywordsParser();
            $parser->start($site);
        }
    }

    public function actionParseSites($page){
        $parser = new LiSitesParser;
        $parser->start($page);
    }

    public function actionLi2Parse($debug = false){
        $parser = new Li2KeywordsParser(true, $debug);
        $parser->start();
    }

    public function actionLi2Private($debug = false){
        $parser = new Li2KeywordsParser(true, $debug);
        $parser->rus_proxy = false;
        $parser->parse_private = true;
        $parser->period = Li2KeywordsParser::PERIOD_DAY;
        $parser->start();
    }

    public function actionPassword($debug = false){
        $parser = new LiPassword(true, $debug);
        $parser->rus_proxy = false;
        $parser->start();
    }

    public function actionMailruSites(){
        $parser = new MailruSitesParser();
        $parser->start();
    }

    public function actionMailruKeywords($debug = false){
        $parser = new MailruKeywordsParser(true, $debug);
        $parser->start();
    }

    public function actionMailruDayKeywords($debug = false){
        $parser = new MailruKeywordsParser(true, $debug);
        $parser->start(1);
    }
}

