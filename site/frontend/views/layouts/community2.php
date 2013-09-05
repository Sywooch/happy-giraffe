<?php $this->beginContent('//layouts/community'); ?>

    <div class="col-1">
        <?php $this->renderPartial('application.modules.community.views.default._users2'); ?>

        <div class="banner">
            <script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- Giraffe - new -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:240px;height:400px"
                 data-ad-client="ca-pub-3807022659655617"
                 data-ad-slot="4550457687"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>

    <div class="col-23-middle ">

        <?=$content ?>

    </div>

<?php $this->endContent(); ?>