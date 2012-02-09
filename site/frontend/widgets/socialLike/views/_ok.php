<?php
Yii::app()->clientScript
    ->registerScriptFile('http://stg.odnoklassniki.ru/share/odkl_share.js')
    ->registerCssFile('http://stg.odnoklassniki.ru/share/odkl_share.css')
    ->registerScript('ok_init', 'ODKL.init();', CClientScript::POS_READY);
?>
<div style="float: left;">
    <a class="odkl-klass-stat" href="<?php echo $this->options['url']; ?>" onclick="ODKL.Share(this);return false;" ><span>0</span></a>
</div>