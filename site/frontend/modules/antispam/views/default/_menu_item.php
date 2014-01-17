<?php
/**
 * @var string $label
 * @var strin $ico
 * @var int $count
 * @var bool $sub
 */
if (! isset ($sub))
    $sub = true;
?>

<span class="side-menu_i-hold"><span class="side-menu_ico side-menu_ico__<?=$ico?>"></span><span class="side-menu_tx"><?=$label?></span><?php if ($count > 0): ?><span class="side-menu_count<?php if ($sub): ?>-sub<?php endif; ?>"><?=$count?></span><?php endif; ?></span><span class="verticalalign-m-help"></span>