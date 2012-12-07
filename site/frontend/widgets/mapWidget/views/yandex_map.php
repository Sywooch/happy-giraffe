<div id="<?=$map_id ?>" style="width:<?= $this->width ?>px;height:<?= $this->height ?>px;"></div>
<?php
/*$js = '
HMap.map_id = "'.$map_id.'";
HMap.address = "'.$this->user->address->getLocationString().'";
HMap.initYandexMap();';

Yii::app()->clientScript->registerScript('register_yandex_map-'.$map_id,$js);*/

?><script type="text/javascript">
    $(function() {
        var map = new HYandexMap();
        map.create("<?= $map_id ?>", "<?= $this->locationString ?>");
    });
</script>