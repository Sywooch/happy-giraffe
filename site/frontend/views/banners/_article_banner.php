<div class="article-banner">
    <div class="buzzplayer-stage" data-hash="XKYmYyY14N0uRxfFufNXA3md5rGHF7KhvnCf3IJaccg" data-width="500" data-expandable="true" data-target=".b-markdown:p">
        <script type="text/javascript">
            require(['http://tube.buzzoola.com/new/build/buzzlibrary.js']);

            <?php if (false): ?>
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
            <?php endif; ?>
        </script>
    </div>
</div>
<?php if(false): ?>
<?php
    $this->beginWidget('AdsWidget', array(
        'dummyTag' => 'adfox',
    ));
    echo $this->renderPartial('site.frontend.widgets.views.ads.adfox.680x470');
    $this->endWidget();
?>
<?php endif; ?>