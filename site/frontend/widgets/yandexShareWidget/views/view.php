<?php
/**
 * @var YandexShareWidget $this
 * @var string $json
 */
?>


<div class="custom-likes-b">
    <div class="custom-likes-b_slogan">Поделитесь с друзьями!</div>

    <div class="like-block fast-like-block" style="font-size: 11px;">
        <span id="<?=$this->getElementId()?>"></span>
        <script type="text/javascript">
            new Ya.share(<?=$json?>);
        </script>
    </div>
</div>