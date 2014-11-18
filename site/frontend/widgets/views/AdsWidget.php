<?php
/**
 * @var AdsWidget $this
 * @var string $contents
 * @var string $mediaQuery
 */

$htmlOptions = array(
    'class' => 'ad',
);
if ($mediaQuery !== null) {
    $htmlOptions['data-matchmedia'] = $mediaQuery;
}
$tag = CHtml::openTag('div', $htmlOptions);
$tag = str_replace('>', ' data-lazyad>', $tag);
?>

<?=$tag?>
    <script type="text/lazyad">
        <?=$contents?>
    </script>
</div>