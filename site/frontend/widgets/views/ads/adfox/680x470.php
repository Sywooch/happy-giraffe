<!--AdFox START-->
<!--giraffe-->
<!--Площадка: Весёлый Жираф / * / *-->
<!--Тип баннера: Безразмерный 680х470-->
<!--Расположение: <низ страницы>-->
<!-- ________________________AdFox Asynchronous code START__________________________ -->
<script type="text/javascript">
    if (typeof(pr) == 'undefined') { var pr = Math.floor(Math.random() * 1000000); }
    if (typeof(document.referrer) != 'undefined') {
        if (typeof(afReferrer) == 'undefined') {
            afReferrer = escape(document.referrer);
        }
    } else {
        afReferrer = '';
    }
    var addate = new Date();

    var scrheight = '', scrwidth = '';
    if (self.screen) {
        scrwidth = screen.width;
        scrheight = screen.height;
    } else if (self.java) {
        var jkit = java.awt.Toolkit.getDefaultToolkit();
        var scrsize = jkit.getScreenSize();
        scrwidth = scrsize.width;
        scrheight = scrsize.height;
    }

    var dl = escape(document.location);
    var pr1 = Math.floor(Math.random() * 1000000);

    document.write('<div id="AdFox_banner_'+pr1+'"><\/div>');
    document.write('<div style="visibility:hidden; position:absolute;"><iframe id="AdFox_iframe_'+pr1+'" width=1 height=1 marginwidth=0 marginheight=0 scrolling=no frameborder=0><\/iframe><\/div>');

    require(['/javascripts/fox.js'], function() {
        AdFox_getCodeScript(1, pr1, '//ads.adfox.ru/211012/prepareCode?pp=i&amp;ps=bkqy&amp;p2=evor&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr + '&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;pdw=' + scrwidth + '&amp;pdh=' + scrheight + '&amp;dl=' + dl + '&amp;pr1=' + pr1);
    });
</script>
<!-- _________________________AdFox Asynchronous code END___________________________ -->