<div id="<?=$map_id ?>" style="width:<?= $this->width ?>px;height:<?= $this->height ?>px;"></div>
<script type="text/javascript">
    $(function() {
        var map = new HYandexMap();
        map.create("<?= $map_id ?>", "<?= $this->location ?>");
    });
</script>