<div id="<?=$map_id ?>" style="width:<?= $this->width ?>px;height:<?= $this->height ?>px;"></div>
<?php
/*$js = '
HMap.map_id = "'.$map_id.'";
HMap.address = "'.$this->user->getUserAddress()->getLocationString().'";
HMap.initGoogleMap();';

Yii::app()->clientScript->registerScript('register_google_map-'.$map_id,$js);*/

?>
<script type="text/javascript">
    $(function() {
        var map = new HGoogleMap();
        map.create("<?= $map_id ?>", "<?= $this->user->getUserAddress()->getLocationString() ?>");
    });
</script>