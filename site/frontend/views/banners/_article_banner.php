<div class="buzzplayer-stage" data-hash="XKYmYyY14N0uRxfFufNXA3md5rGHF7KhvnCf3IJaccg" data-width="100%" data-expandable="true" >
    <script type="text/javascript">
        (function(w, d) {
            var c = d.createElement("script");
            c.src = "http://tube.buzzoola.com/new/build/buzzlibrary.js";
            c.type = "text/javascript";
            c.async = !0;
            var f = function() {
                var p = d.getElementsByTagName("script")[0];
                p.parentNode.insertBefore(c, p);
            };
            "[object Opera]" == w.opera ? d.addEventListener("DOMContentLoaded", f, !1) : f();
        })(window, document);
    </script>
</div>

<div class="article-banner">
    <?php
    $this->beginWidget('AdsWidget', array(
        'dummyTag' => 'adfox',
    ));
    echo $this->renderPartial('site.frontend.widgets.views.ads.adfox.680x470');
    $this->endWidget();
    ?>
</div>