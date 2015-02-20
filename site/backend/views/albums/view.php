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
        googletag.pubads().addEventListener('slotRenderEnded', function(event) {
            $('#' + event.slot.b.d).find('iframe').contents().find('.article-anonce').addClass('article-anonce__s');
            $('#' + event.slot.b.d).find('iframe').contents().find('.article-anonce_tag').remove();
            require(['iframeResizer'], function(resizer) {
                $('#' + event.slot.b.d).find('iframe').iFrameResize({ heightCalculationMethod: 'lowestElement', checkOrigin: false, autoResize: false });
            });
        });
        googletag.defineSlot('/51841849/anounce_small', [300, 315], 'anounce-small-1').addService(googletag.pubads());
        googletag.defineSlot('/51841849/anounce_small', [300, 315], 'anounce-small-2').addService(googletag.pubads());
        googletag.defineSlot('/51841849/anounce_small', [300, 315], 'anounce-small-3').addService(googletag.pubads());
        googletag.pubads().enableSingleRequest();
        googletag.enableServices();
    });
</script>

<script type="text/javascript">
    $('.bnr-base:first').css('padding-left', '30px');
    $('.b-main_col-sidebar').append('<div id="anounce-small-1" class="article-anonce article-anonce__s" style="margin-bottom: 20px">');
    $('.b-main_col-sidebar').append('<div id="anounce-small-2" class="article-anonce article-anonce__s" style="margin-bottom: 20px">');
    $('.b-main_col-sidebar').append('<div id="anounce-small-3" class="article-anonce article-anonce__s" style="margin-bottom: 20px">');
    googletag.cmd.push(function() { googletag.display('anounce-small-1'); });
    googletag.cmd.push(function() { googletag.display('anounce-small-2'); });
    googletag.cmd.push(function() { googletag.display('anounce-small-3'); });
</script>