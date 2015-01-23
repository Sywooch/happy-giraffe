<?php $this->pageTitle = 'Реклама на Веселом Жирафе'; ?>
<div class="content-cols padding-t20">
    <?php $this->renderPartial('pages/_menu'); ?>
    <div class="col-23-middle">
        <div class="col-white-hoar">
            <h1 class="heading-title margin-t20 clearfix">Реклама на сайте</h1>
            <div class="margin-20 padding-b20">
                <div class="wysiwyg-content">
                    <p>Веселый Жираф – это социальная сеть для всей семьи, которая собрала миллионы мам и пап со всей России.</p>

                    <p>Веселый Жираф предлагает широкий выбор рекламных возможностей: вы сможете разместить баннер или рекламную статью, провести фотоконкурс или осуществить самый смелый спецпроект.<br>
                    Мы готовы и будем рады реализовать самые сложные рекламные задачи.</p>

                    <p><a href="/adv/media/happy-giraffe-2014-12.pdf">Скачать медиа-кит</a></p>

                    <p>По вопросам размещения рекламы и предоставления скидок: <a href="mailto:info@happy-giraffe.ru">info@happy-giraffe.ru</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Piwik -->
<script type="text/javascript">
    var _paq = _paq || [];
    _paq.push(["trackPageView"]);
    _paq.push(["enableLinkTracking"]);

    (function() {
        var u=(("https:" == document.location.protocol) ? "https" : "http") + "://piwik.happy-giraffe.ru/";
        _paq.push(["setTrackerUrl", u+"piwik.php"]);
        _paq.push(["setSiteId", "3"]);
        <?php if (! Yii::app()->user->isGuest): ?>
            _paq.push(['setUserId'], '<?=Yii::app()->user->id?>');
        <?php endif; ?>
        var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
        g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
    })();
</script>
<!-- End Piwik Code -->