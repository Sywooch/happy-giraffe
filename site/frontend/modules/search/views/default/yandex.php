

<?php
    // title
    $this->pageTitle = 'Результат поиска';

    $this->breadcrumbs = array(
        'Поиск по сайту'
    );
    // $this->breadcrumbs = array(
    //     'Интересы и увлечения' => array('/interests-and-hobby'),
    //     'Наш автомобиль' => array('/auto'),
    //     'Маршруты'
    // );

    if(Yii::app()->user->isGuest)
    {
        //Yii::app()->clientScript->registerPackage('lite-default');
        Yii::app()->clientScript->registerCssFile('/lite/css/min/services.css');
    }
?>
<?php
if(Yii::app()->user->isGuest)
{
    //Тут для гостей    
?>

    <div class="b-main_cont">
        <div class="b-main_col-hold clearfix">
            <div class="b-main_col-article">
<?php
}
else
{
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
                                    'homeLink' => '<li class="b-crumbs_li"><a href="' . $this->createUrl('/site/index') . '" class="b-crumbs_a">Главная</a> </li>',
                                    'activeLinkTemplate' => '<li class="b-crumbs_li"><a href="{url}" class="b-crumbs_a">{label}</a></li>',
                                    'inactiveLinkTemplate' => '<li class="b-crumbs_li b-crumbs_li__last"><span class="b-crumbs_last">{label}</span></li>',
                                    'links' => $this->breadcrumbs,
                                ));
                                ?>
                            </div>
                        <?php endif; ?>
                        <div class="b-main_col-article">


<?php
}
?>
                <h1 class="heading-link-xxl">Результат поиска</h1>
                <div class="ya-site-form ya-site-form_inited_no" onclick="return {'action':'<?=Yii::app()->createAbsoluteUrl('search')?>','arrow':false,'bg':'transparent','fontsize':12,'fg':'#000000','language':'ru','logo':'rb','publicname':'search','suggest':true,'target':'_self','tld':'ru','type':3,'usebigdictionary':true,'searchid':2166305,'webopt':false,'websearch':false,'input_fg':'#000000','input_bg':'#ffffff','input_fontStyle':'normal','input_fontWeight':'normal','input_placeholder':'','input_placeholderColor':'#000000','input_borderColor':'#7f9db9'}"><form action="http://yandex.ru/sitesearch" method="get" target="_self"><input type="hidden" name="searchid" value="2166305"/><input type="hidden" name="l10n" value="ru"/><input type="hidden" name="reqenc" value=""/><input type="text" name="text" value=""/><input type="submit" value="Найти"/></form></div><style type="text/css">.ya-page_js_yes .ya-site-form_inited_no { display: none; }</style><script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;if((' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1){e.className+=' ya-page_js_yes';}s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,'yandex_site_callbacks');</script>

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
                <div class="footer-push"></div>
                <?php $this->renderPartial('//_footer'); ?>
            </div>
        </div>
    </div>  

<?php
}
?>




<!-- Наверно, лучше включить css в текст старницы -->
<!-- <link rel="stylesheet" type="text/css" href="/lite/css/dev/search.css" /> -->

<style>
    #ya-site-form0 .ya-site-form__search-input{padding:0 0 15px}#ya-site-form0 .ya-site-form__form .ya-site-form__input-text{display:block;width:100%;height:38px;border:2px solid #a3e19c!important;padding:10px 40px 10px 15px;font-size:14px!important;line-height:16px!important;background:#fff;color:#333;border-radius:18px;-webkit-transition:all .3s ease;-o-transition:all .3s ease;transition:all .3s ease;word-wrap:normal;word-break:normal}#ya-site-form0 .ya-site-form__form .ya-site-form__input-text:focus{border-color:#afd0fb!important}#ya-site-form0 .ya-site-form__search-input-layout-r{position:relative;width:0}#ya-site-form0 .ya-site-form__submit_type_image{position:absolute;top:0;right:0;width:40px;height:38px;background:#aaa;background:url(/lite/images/ya-site-form__submit_type_image.png) no-repeat}#ya-site-form0 .ya-site-form__submit_type_image:hover{background-position:-40px 0}.bhead_result{margin-top:0}.b-head{position:relative}.b-head__l,.b-head__r{display:none}.b-head__logo{margin-bottom:8px}.b-head__found{padding-left:5px}.b-head__specify{padding:0}.b-specification-list{font-size:13px;color:#999!important}.b-specification-item{margin:0 15px 2px 0;padding:0}.b-specification-list .b-pseudo-link{color:#666!important;border-bottom:1px dotted #666}#ya-site-results .b-specification-list .b-pseudo-link:hover{color:#333!important;border-color:#333;text-decoration:none}.b-specification-list__reset{margin:0 18px 0 0;padding:0;float:none;display:block}#ya-site-results{color:#333; margin-bottom: 50px;}.b-body-items{padding:0}#ya-site-results .b-serp-item__number,.b-serp-item__number{display:none}#ya-site-results .b-serp-item__title-link,#ya-site-results .b-serp-item__title-link:link{font-size:15px;font-weight:700;color:#196eb9;text-decoration:underline}#ya-site-results .b-pseudo-link:hover,#ya-site-results .b-serp-item__title-link:link:hover,#ya-site-results .b-serp-item__title-link:visited:hover{color:#90c3ef!important;text-decoration:underline}#ya-site-results .b-serp-list .b-copyright__link:visited,#ya-site-results .b-serp-list :visited{color:#8a74b0}#ya-site-results .b-serp-item__text{margin:3px 0 5px;font-size:14px;color:#666}#ya-site-results .b-serp-item__text b{color:#333}#ya-site-results .b-direct .url,#ya-site-results .b-direct .url a:link,#ya-site-results .b-direct .url a:visited{color:#3498db}#ya-site-results .b-serp-item__links-link{color:#3498db!important}.b-serp-item__links-item{display:none}#ya-site-results .tsearch_list__title-link,#ya-site-results .tsearch_list__title-link:link,#ya-site-results .tsearch_list__title-link:visited{font-size:12px;color:#3498db;text-decoration:none;font-weight:400}#ya-site-results .tsearch_list__title-link:hover,#ya-site-results .tsearch_list__title-link:visited:hover{color:#f17504!important;text-decoration:none}.b-pager__arrow,.b-pager__title{display:none}body .g-gap-horizontal{margin-left:0}#ya-site-results .b-pager__pages :link,#ya-site-results .b-pager__pages :visited{display:inline-block;margin:0 3px;font-size:17px;line-height:30px;padding:0 10px;background:#fff;color:#b5b5b5;text-decoration:none;font-weight:400}#ya-site-results .b-pager__pages :link:hover,#ya-site-results .b-pager__pages :visited:hover{color:#666!important}#ya-site-results .b-pager__current{display:inline-block;padding:0 10px;font-size:17px;line-height:30px;background-color:#6accff;font-weight:700;color:#fff!important;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}.b-pager__sorted{font-size:13px;color:#666}#ya-site-results .b-pager__select{display:table-cell;margin:3px 0;background-color:#f7f7f7}#ya-site-results .b-pager__sorted .b-link{font-weight:400;font-size:13px;color:#3498db!important;display:block}#ya-site-results .b-pager__sorted .b-link:hover{text-decoration:none}.ya-copy{display:block}.ya-copy a{display:inline-block;text-align:right}@media (min-width:480px){#ya-site-form0 .ya-site-form__search-input{padding-bottom:22px}.bhead_result{margin:0 0 -17px}.b-head__specify{text-align:right}.b-specification-list{margin-left:150px}.b-specification-item{margin:0 18px 0 10px}.b-body-items{padding-right:50px}#ya-site-results .b-pager__select{display:inline-block;margin:0 4px}#ya-site-results .b-pager__sorted .b-link{display:inline-block}
        .ya-copy{display:block;position:absolute;bottom:0;right:0;color:#666}}
        @media (min-width:640px){.b-specification-list__reset{float:right}}
        @media (min-width:768px){.b-body-items{padding-right:80px}}
        .g-gap-vertical {margin-bottom: 30px;}
        .b-pager__pages {padding-bottom: 40px;}
        .b-pager__sorted {display:none;}
</style>
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
