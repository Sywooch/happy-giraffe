<?php
/* @var $this CommunityController
 * @var $data CommunityContent
*/

$this->renderPartial('_post', array('data' => $data, 'full' => true));

$this->renderPartial('_prev_next', array('data' => $data));
?>

<div style="margin-top: 40px; margin-bottom: 40px;">
    <!-- Яндекс.Директ -->
    <div id="yandex_ad_2"></div>
    <script type="text/javascript">
        (function(w, d, n, s, t) {
            w[n] = w[n] || [];
            w[n].push(function() {
                Ya.Direct.insertInto(87026, "yandex_ad_2", {
                    stat_id: 1955456,
                    site_charset: "utf-8",
                    ad_format: "direct",
                    font_size: 1.2,
                    type: "vertical",
                    limit: 2,
                    title_font_size: 3,
                    site_bg_color: "FFFFFF",
                    title_color: "0281B0",
                    url_color: "999999",
                    text_color: "000000",
                    hover_color: "029AD2"
                });
            });
            t = d.getElementsByTagName('head')[0];
            s = d.createElement("script");
            s.type = "text/javascript";
            s.src = "http://an.yandex.ru/system/context.js";
            s.setAttribute("async", "true");
            t.insertBefore(s, t.firstChild);
        })(window, document, "yandex_context_callbacks");
    </script>
</div>

<?php $this->renderPartial('//banners/community_24_700x346'); ?>

<?php

$this->widget('application.widgets.commentWidget.CommentWidget', array('model' => $data));

$this->widget('application.widgets.seo.SeoLinksWidget');

$remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
$remove_tmpl->registerTemplates();
$this->endWidget();
