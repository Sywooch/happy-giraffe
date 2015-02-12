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
        googletag.defineSlot('/51841849/main_big', [240, 400], 'div-gpt-ad-1417646354258-0').addService(googletag.pubads());
        googletag.defineSlot('/51841849/main_fotopost', [240, 400], 'div-gpt-ad-1417646354258-1').addService(googletag.pubads());
        googletag.defineSlot('/51841849/main_lower', [240, 400], 'div-gpt-ad-1417646354258-2').addService(googletag.pubads());
        googletag.defineSlot('/51841849/main_lower', [240, 400], 'div-gpt-ad-1417646354258-3').addService(googletag.pubads());
        googletag.defineSlot('/51841849/main_lower', [240, 400], 'div-gpt-ad-1417646354258-4').addService(googletag.pubads());
        googletag.pubads().enableSingleRequest();
        googletag.enableServices();
    });

    selector =  $('.homepage-posts_col-hold');
    selector.append("<div id='div-gpt-ad-1417646354258-0' class='article-anonce article-anonce__red article-anonce__xl' style='height:450px'></div>");
    googletag.cmd.push(function() {
        googletag.display('div-gpt-ad-1417646354258-0');
        googletag.pubads().addEventListener('slotRenderEnded', function(event) {

            f = function(){
                if($.data(this,'register') !== true){
                    FrameManager.registerFrame(this);
                    $.data(this,'register', true);
                }
            };
            if(event.slot.getName() === '/51841849/main_big'){
                $('.article-anonce__xl > div, .article-anonce__xl > div > iframe').css('height','100%').css('width','100%');

            }
            if(event.slot.getName() === '/51841849/main_fotopost'){
                $('.article-anonce__ico > div, .article-anonce__ico > div > iframe').css('height','100%').css('width','100%');

            }
            if(event.slot.getName() === '/51841849/main_lower'){
                $('.article-anonce__s > div, .article-anonce__s > div > iframe').css('width','100%').removeAttr('height').load(f);
//      $('.article-anonce__s').css('height','');
            }


        });
    });

    <!-- main_fotopost -->
    selector.append("<div id='div-gpt-ad-1417646354258-1' class='article-anonce article-anonce__lilac article-anonce__ico' style='height:450px'></div>");
    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1417646354258-1'); });



    <!-- main_lower -->
    selector.append("<div id='div-gpt-ad-1417646354258-2' class='article-anonce article-anonce__yellow article-anonce__s'></div>");
    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1417646354258-2'); });

    <!-- main_lower2 -->
    selector.append("<div id='div-gpt-ad-1417646354258-3' class='article-anonce article-anonce__yellow article-anonce__s'></div>");
    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1417646354258-3'); });
    <!-- main_lower3 -->
    selector.append("<div id='div-gpt-ad-1417646354258-4' class='article-anonce article-anonce__yellow article-anonce__s'></div>");
    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1417646354258-4'); });
</script>