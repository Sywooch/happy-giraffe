<?php
/**
 * @var AdsWidget $this
 * @var string $contents
 */

$attrs = array(
    'class' => 'ad',
);
if ($this->width) {
    $attrs['data-adwidth'] = $this->width;
}
if ($this->height) {
    $attrs['data-adheight'] = $this->height;
}
if ($this->mediaQuery) {
    $attrs['data-matchmedia'] = $this->mediaQuery;
}
$tag = CHtml::openTag('div', $attrs);
$tag = str_replace('>', ' data-lazyad>', $tag);
?>

<?=$tag?>
    <script type="text/lazyad">
        <?=$contents?>
    </script>
</div>