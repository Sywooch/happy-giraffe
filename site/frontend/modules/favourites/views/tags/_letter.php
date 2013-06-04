<?php
/**
 * @var string $letter
 * @var bool $hasTags
 * @var bool $active
 * @var TagsController $this
 */
?>

<li class="alphabet-b_li">
    <?php if ($hasTags): ?>
        <a href="<?=$this->createUrl('/favourites/tags/index', array('type' => TagsController::TYPE_BY_LETTER, 'letter' => $letter))?>" class="alphabet-b_a<?php if ($active): ?> active<?php endif; ?>"><?=$letter?></a>
    <?php else: ?>
        <span class="alphabet-b_tx"><?=$letter?></span>
    <?php endif; ?>
</li>