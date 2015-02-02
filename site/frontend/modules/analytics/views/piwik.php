<?php
/**
 * @var int $idSite
 * @var string $baseUrl
 */
?>

<!-- Piwik -->
<script type="text/javascript">
    var _paq = _paq || [];
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
        var u="<?=$baseUrl?>";
        _paq.push(['setTrackerUrl', u+'piwik.php']);
        _paq.push(['setSiteId', <?=$idSite?>]);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
    })();
</script>
<noscript><p><img src="<?=$baseUrl?>piwik.php?idsite=<?=$idSite?>" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->
