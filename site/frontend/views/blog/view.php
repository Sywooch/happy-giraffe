<?php $this->renderPartial('/community/_post', array('data' => $data, 'full' => true)); ?>

<?php if ($data->type_id != 5): ?>
<?php $this->renderPartial('/community/_prev_next', array('data' => $data)); ?>
<?php endif; ?>

<div style="margin-top: 40px; margin-bottom: 40px;">
    <!-- Яндекс.Директ -->
    <div id="yandex_ad_2"></div>
    <script type="text/javascript">
        (function(w, d, n, s, t) {
            w[n] = w[n] || [];
            w[n].push(function() {
                Ya.Direct.insertInto(87026, "yandex_ad_2", {
                    stat_id: 2,
                    site_charset: "utf-8",
                    ad_format: "direct",
                    font_size: 1,
                    type: "horizontal",
                    limit: 3,
                    title_font_size: 3,
                    site_bg_color: "FFFFFF",
                    header_bg_color: "FEEAC7",
                    title_color: "0000CC",
                    url_color: "006600",
                    text_color: "000000",
                    hover_color: "0066FF",
                    favicon: true
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

<?php $this->widget('application.widgets.commentWidget.CommentWidget', array(
    'model' => $data,
)); ?>

<?php $this->widget('application.widgets.seo.SeoLinksWidget'); ?>

<?php
$remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
$remove_tmpl->registerTemplates();
$this->endWidget();
?>