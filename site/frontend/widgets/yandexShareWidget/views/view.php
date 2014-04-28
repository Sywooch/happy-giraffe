<?php
/**
 * @var YandexShareWidget $this
 * @var string $json
 */
?>

<span id="<?=$this->getElementId()?>"></span>
<script type="text/javascript">
    new Ya.share(<?=$json?>);
</script>