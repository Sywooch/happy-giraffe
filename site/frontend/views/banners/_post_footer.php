<div style="margin: 15px 15px 15px 0;">
    <?php $widget = $this->beginWidget('AdsWidget', array('dummyTag' => 'yandex-direct')); ?>
    <div id="yandex_ad_<?=$widget->id?>"></div>
    <script type="text/javascript">
        (function(w, d, n, s, t) {
            w[n] = w[n] || [];
            w[n].push(function() {
                Ya.Direct.insertInto(127976, "yandex_ad_<?=$widget->id?>", {
                    stat_id: 6,
                    ad_format: "direct",
                    font_size: 1.1,
                    type: "vertical",
                    border_type: "ad",
                    limit: 2,
                    title_font_size: 3,
                    links_underline: true,
                    site_bg_color: "FFFFFF",
                    header_bg_color: "FFFFFF",
                    border_color: "F1F1F1",
                    title_color: "02B4F2",
                    url_color: "000000",
                    text_color: "000000",
                    hover_color: "63CDFF",
                    no_sitelinks: true
                });
            });
            t = d.getElementsByTagName("script")[0];
            s = d.createElement("script");
            s.src = "//an.yandex.ru/system/context.js";
            s.type = "text/javascript";
            s.async = true;
            t.parentNode.insertBefore(s, t);
        })(window, document, "yandex_context_callbacks");
    </script>

    <?php if (false): ?>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Объявления -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:468px;height:15px"
         data-ad-client="ca-pub-3807022659655617"
         data-ad-slot="8926657285"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    <?php endif; ?>
    <?php $this->endWidget(); ?>
</div>