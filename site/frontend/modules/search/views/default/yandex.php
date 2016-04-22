

<?php
    // title
    $this->pageTitle = 'Результат поиска';

//    $this->breadcrumbs = array(
//        'Поиск по сайту'
//    );
    // $this->breadcrumbs = array(
    //     'Интересы и увлечения' => array('/interests-and-hobby'),
    //     'Наш автомобиль' => array('/auto'),
    //     'Маршруты'
    // );

    if(Yii::app()->user->isGuest)
    {
        //Yii::app()->clientScript->registerPackage('lite-default');
       Yii::app()->clientScript->registerCssFile('/lite/css/min/services-user.css');
    }
?>
<?php
if(Yii::app()->user->isGuest)
{
    //Тут для гостей
?>

    <div class="b-main_cont">
        <div class="b-main_col-hold clearfix">
            <div class="b-main_col-article b-main_col-search">
<?php
}
else
{
    $this->bodyClass = 'theme theme__adfox'
    // Тут для залогиненых пользователей
?>
    <div class="layout-search-hold">
        <div class="layout-wrapper_frame clearfix">
            <div class="b-main b-main__white"  style="margin: 0 -20px; padding: 30px 0 0;">
                <div class="b-main_cont">
                    <div class="b-main_col-hold" style="margin-left: 60px;">
                        <?php if ($this->breadcrumbs): ?>
                            <div class="b-crumbs b-crumbs__s" style="margin-left: 10px;">
                                <div class="b-crumbs_tx">Я здесь:</div>
                                <?php
                                $this->widget('zii.widgets.CBreadcrumbs', array(
                                    'tagName' => 'ul',
                                    'separator' => ' &nbsp; ',
                                    'htmlOptions' => array('class' => 'b-crumbs_ul'),
                                    'homeLink' => false,
                                    'activeLinkTemplate' => '<li class="b-crumbs_li"><a href="{url}" class="b-crumbs_a">{label}</a></li>',
                                    'inactiveLinkTemplate' => '<li class="b-crumbs_li b-crumbs_li__last"><span class="b-crumbs_last">{label}</span></li>',
                                    'links' => $this->breadcrumbs,
                                ));
                                ?>
                            </div>
                        <?php endif; ?>
                        <div class="b-main_col-article b-main_col-search">


<?php
}
?>
                <h1 class="heading-link-xxl">Результат поиска</h1>
                <div class="ya-site-form ya-site-form_inited_no" onclick="return {'action':'<?=Yii::app()->createAbsoluteUrl('search')?>','arrow':false,'bg':'transparent','fontsize':12,'fg':'#000000','language':'ru','logo':'rb','publicname':'Yandex Site Search #1883818','suggest':true,'target':'_self','tld':'ru','type':3,'usebigdictionary':true,'searchid':1883818,'webopt':false,'websearch':false,'input_fg':'#000000','input_bg':'#ffffff','input_fontStyle':'normal','input_fontWeight':'normal','input_placeholder':'','input_placeholderColor':'#000000','input_borderColor':'#7f9db9'}"><form action="http://yandex.ru/sitesearch" method="get" target="_self"><input type="hidden" name="searchid" value="1883818"/><input type="hidden" name="l10n" value="ru"/><input type="hidden" name="reqenc" value=""/><input type="text" name="text" value=""/><input type="submit" value="Õ‡ÈÚË"/></form></div><style type="text/css">.ya-page_js_yes .ya-site-form_inited_no { display: none; }</style><script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;if((' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1){e.className+=' ya-page_js_yes';}s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,'yandex_site_callbacks');</script>

                <div id="ya-site-results" onclick="return {'tld': 'ru','language': 'ru','encoding': '','htmlcss': '1.x','updatehash': true}"></div><script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0];s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Results.init();})})(window,document,'yandex_site_callbacks');</script>


<?php
if(Yii::app()->user->isGuest)
{
    //Тут для гостей
?>
            </div>
        </div>
    </div>
<?php
}
else
{
    // Тут для залогиненых пользователей
?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
}
?>

<script>
  $(document).bind('yass.ready', function(event) {

        // Заменяем текст в перед поисковой выдачей
        var bhead_result = $('.b-head__found').text();
        var bhead_result_nstr = bhead_result.substring(6); //без "нашел"
        var bhead_result_n = parseInt(bhead_result_nstr); // число
        var bhead_result_nl = (bhead_result_n+'').length; // длина строки числа
        var bhead_result_text = bhead_result.substring(bhead_result_nl+6); //без "нашел число"
        $('.bhead_result').remove();
        if ( bhead_result_n > 0 ){
            $('#ya-site-results > div > yass-div').prepend('<div class="bhead_result">Найдено <b>'+bhead_result_n+'</b> '+bhead_result_text+'</div>');
        }

        // Поисковая технология Яндекс
        $('.b-wrapper_is-bem_yes').append('<div class="ya-copy">Поисковая технология <a href="http://site.yandex.ru/?from=serp" title="Яндекс" onclick="this.blur();" target="_blank"><img alt="Яндекс" src="http://yandex.st/sitesearch2/35.5//blocks/l-head/ru/yandex52x21x24-rb.png" height="14" style="vertical-align: top; padding: 0 0 0 4px;"></a></div>');

        //
        $(".b-serp-list .b-serp-item").each(function (i) {
            var oblinkh3 = $(this).find('.b-serp-item__title-link');
            //Отмена события onmousedown в результате поиска, что бы пользователь при клике на результат сразу переходил на сайт без редиректа
            oblinkh3.removeAttr('onmousedown')

            var oblink = $(this).find('.b-serp-url__item');
            if(oblink.length>1) {
                oblink=oblink.eq(0);
            }
            oblink.html('<a class="tsearch_list__title-link" target="_blank" href="'+oblinkh3.attr('href')+'">'+oblink.text()+'</a>');
        });

  });
</script>
