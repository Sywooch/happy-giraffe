<script src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<!-- Изменение размера -->
<script type='text/javascript' src="https://rawgit.com/daepark/postmessage/master/postmessage.js"></script>
<script>
    var FrameManager =
    {
        registerFrame : function(frame)
        {
            pm({
                target: window.frames[frame.id],
                type:   "register",
                data:   {id:frame.id},
                url: frame.contentWindow.location
            });

            pm.bind(frame.id, function(data) {
                var iframe = document.getElementById(data.id);
                if (iframe == null) return;
                iframe.style.height = (data.height+12).toString() + "px";
            });
        }
    };
</script>


<script type='text/javascript'>
    var googletag = googletag || {};
    googletag.cmd = googletag.cmd || [];
    (function() {
        var gads = document.createElement('script');
        gads.async = true;
        gads.type = 'text/javascript';
        var useSSL = 'https:' == document.location.protocol;
        gads.src = (useSSL ? 'https:' : 'http:') +
        '//www.googletagservices.com/tag/js/gpt.js';
        var node = document.getElementsByTagName('script')[0];
        node.parentNode.insertBefore(gads, node);
    })();
</script>

<script type='text/javascript'>
    googletag.cmd.push(function() {
        googletag.defineSlot('/51841849/sidebar_for_top_ads', [240, 400], 'div-gpt-ad-1417958877586-0').addService(googletag.pubads());
        googletag.defineSlot('/51841849/sidebar_lower', [240, 400], 'div-gpt-ad-1417958877586-1').addService(googletag.pubads());
        googletag.defineSlot('/51841849/sidebar_lower', [240, 400], 'div-gpt-ad-1417958877586-2').addService(googletag.pubads());
        googletag.defineSlot('/51841849/sidebar_lower', [240, 400], 'div-gpt-ad-1417958877586-3').addService(googletag.pubads());
        googletag.defineSlot('/51841849/sidebar_lower', [240, 400], 'div-gpt-ad-1417958877586-4').addService(googletag.pubads());
        googletag.defineSlot('/51841849/sidebar_lower', [240, 400], 'div-gpt-ad-1417958877586-5').addService(googletag.pubads());
        googletag.pubads().enableSingleRequest();
        googletag.enableServices();
    });

    googletag.cmd.push(function() {
        googletag.pubads().addEventListener('slotRenderEnded', function(event) {
            f = function(){
                if($.data(this,'register') !== true){
                    FrameManager.registerFrame(this);
                    $.data(this,'register', true);
                }
            };
            $('.article-anonce__s > div, .article-anonce__s > div > iframe').css('width','100%').removeAttr('height').load(f);
        });
    });

</script>


<script>

    var container = '<div class="recommendations" style="margin: 20px 0;"></div>';
    if ($('.menu-simple').length > 0) {
        $('.menu-simple').before(container);
    } else {
        if ($('aside > div').length > 1) {
            $('aside > div:eq(1)').before(container);
        } else {
            $('aside').append(container);
        }
    }
    var selector = $('.recommendations');

    var createAdPlace = function createAdPlace(id){
        selector.append("<div id='" + id + "' style='width:240px; min-height:250px ' class='article-anonce article-anonce__yellow article-anonce__s'></div>");
        googletag.cmd.push(function() { googletag.display( id ); });
    }

    selector.append('<ins class="adsbygoogle"' +
    'style="display:inline-block;width:250px;height:250px"' +
    'data-ad-client="ca-pub-3807022659655617"' +
    'data-ad-slot="1000868488"></ins>');
    (adsbygoogle = window.adsbygoogle || []).push({});
    createAdPlace('div-gpt-ad-1417958877586-0');
    createAdPlace('div-gpt-ad-1417958877586-1');
    createAdPlace('div-gpt-ad-1417958877586-2');
    selector.append('<ins class="adsbygoogle"' +
    'style="display:inline-block;width:250px;height:250px"' +
    'data-ad-client="ca-pub-3807022659655617"' +
    'data-ad-slot="2477601685"></ins>');
    (adsbygoogle = window.adsbygoogle || []).push({});
    createAdPlace('div-gpt-ad-1417958877586-3');
    createAdPlace('div-gpt-ad-1417958877586-4');
    createAdPlace('div-gpt-ad-1417958877586-5');
</script>


<script src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script type="text/javascript">
    if ({{version}} == 'desktop')
    {
        var ins = '<div style="display: block;width: 468px;height: 60px;margin: 15px auto;"><ins class="adsbygoogle"' +
            'style="display:inline-block;width:468px;height:60px"' +
            'data-ad-client="ca-pub-3807022659655617"' +
            'data-ad-slot="3604741280"></ins></div>';
        $('h1').after(ins);
        (adsbygoogle = window.adsbygoogle || []).push({});
    }
</script>

<script type='text/javascript'>
    var googletag = googletag || {};
    googletag.cmd = googletag.cmd || [];
    (function() {
        var gads = document.createElement('script');
        gads.async = true;
        gads.type = 'text/javascript';
        var useSSL = 'https:' == document.location.protocol;
        gads.src = (useSSL ? 'https:' : 'http:') +
        '//www.googletagservices.com/tag/js/gpt.js';
        var node = document.getElementsByTagName('script')[0];
        node.parentNode.insertBefore(gads, node);
    })();

    var recs = function() {
        $(function() {
            googletag.cmd.push(function() {
                googletag.defineSlot('/51841849/sidebar_recomendation', [240, 400], 'div-gpt-ad-1411042061334-0').addService(googletag.pubads());
                googletag.defineSlot('/51841849/sidebar_recomendation2', [240, 400], 'div-gpt-ad-1411042061334-1').addService(googletag.pubads());
                googletag.defineSlot('/51841849/sidebar_recomendation3', [240, 400], 'div-gpt-ad-1411042061334-2').addService(googletag.pubads());
                googletag.defineSlot('/51841849/sidebar_recomendation4', [240, 400], 'div-gpt-ad-1411042061334-3').addService(googletag.pubads());
                googletag.defineSlot('/51841849/sidebar_recomendation5', [240, 400], 'div-gpt-ad-1411042061334-4').addService(googletag.pubads());
                googletag.defineSlot('/51841849/sidebar_recomendation6', [240, 400], 'div-gpt-ad-1411042061334-5').addService(googletag.pubads());
                googletag.enableServices();
            });
            var container = '<div class="recommendations" style="margin: 20px 0;"></div>';
            if ($('.menu-simple').length > 0) {
                $('.menu-simple').before(container);
            } else {
                if ($('aside > div').length > 1) {
                    $('aside > div:eq(1)').before(container);
                } else {
                    $('aside').append(container);
                }
            }
            var selector = $('.recommendations');
            selector.append('<ins class="adsbygoogle"' +
            'style="display:inline-block;width:250px;height:250px"' +
            'data-ad-client="ca-pub-3807022659655617"' +
            'data-ad-slot="1000868488"></ins>');
            (adsbygoogle = window.adsbygoogle || []).push({});
            selector.append("<div id='div-gpt-ad-1411042061334-0' style='width: 240px; height: 240px;'>");
            googletag.cmd.push(function() { googletag.display('div-gpt-ad-1411042061334-0'); });
            selector.append("<div id='div-gpt-ad-1411042061334-1' style='width: 240px; height: 240px;'>");
            googletag.cmd.push(function() { googletag.display('div-gpt-ad-1411042061334-1'); });
            selector.append('<ins class="adsbygoogle"' +
            'style="display:inline-block;width:250px;height:250px"' +
            'data-ad-client="ca-pub-3807022659655617"' +
            'data-ad-slot="2477601685"></ins>');
            (adsbygoogle = window.adsbygoogle || []).push({});
            selector.append("<div id='div-gpt-ad-1411042061334-2' style='width: 240px; height: 240px;'>");
            googletag.cmd.push(function() { googletag.display('div-gpt-ad-1411042061334-2'); });
            selector.append("<div id='div-gpt-ad-1411042061334-3' style='width: 240px; height: 240px;'>");
            googletag.cmd.push(function() { googletag.display('div-gpt-ad-1411042061334-3'); });
            selector.append('<ins class="adsbygoogle"' +
            'style="display:inline-block;width:250px;height:250px"' +
            'data-ad-client="ca-pub-3807022659655617"' +
            'data-ad-slot="5431068089"></ins>');
            (adsbygoogle = window.adsbygoogle || []).push({});
            selector.append("<div id='div-gpt-ad-1411042061334-4' style='width: 240px; height: 240px;'>");
            googletag.cmd.push(function() { googletag.display('div-gpt-ad-1411042061334-4'); });
            selector.append("<div id='div-gpt-ad-1411042061334-5' style='width: 240px; height: 240px;'>");
            googletag.cmd.push(function() { googletag.display('div-gpt-ad-1411042061334-5'); });
        });
    };

    if ({{version}} == 'desktop') {
        recs();
    }
</script>
<style>
    .recommendations > * {
        margin-bottom: 20px;
    }
    .recommendations > ins {
        margin-bottom: 30px;
    }
</style>