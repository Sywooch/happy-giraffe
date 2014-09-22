<script type="text/javascript">
    isAmd = <?=CJavaScript::encode(Yii::app()->clientScript->useAMD)?>;
    isGuest = <?=CJavaScript::encode(Yii::app()->user->isGuest)?>;
</script>

<div id="epom" style="display: none;">
    <script type="text/javascript">
        //<![CDATA[
        epom_key = "72a16c9d2eac9948f9ad1dcb3fbea949";
        epom_channel = "";
        epom_code_format = "ads-sync.js";
        epom_ads_host = "//smgadserver.com";
        epom_click = "";
        epom_custom_params = {};

        document.write("<script type='text\/javascript' src='"+(location.protocol == 'https:' ? 'https:' : 'http:') + "//smgadserver.com\/js/show_ads.js'><\/script>");
        //]]>
    </script>
</div>

<?php Yii::app()->controller->renderPartial('//counters/_google_tag'); ?>
<?php Yii::app()->controller->renderPartial('//counters/_metrika'); ?>
<?php //Yii::app()->controller->renderPartial('//counters/_ga'); ?>
<?php //Yii::app()->controller->renderPartial('//counters/_top100'); ?>