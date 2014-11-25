<script type="text/javascript">
    dataLayer = [{
        'isAmd': <?=CJavaScript::encode(Yii::app()->clientScript->useAMD)?>,
        'isGuest': <?=CJavaScript::encode(Yii::app()->user->isGuest)?>,
        'isModerator': <?=CJavaScript::encode((! Yii::app()->user->isGuest) && (Yii::app()->user->group != UserGroup::USER))?>,
        'version': <?=CJavaScript::encode(Yii::app()->vm->getVersion())?>
    }];
</script>

<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-K44B85"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-K44B85');</script>
<!-- End Google Tag Manager -->