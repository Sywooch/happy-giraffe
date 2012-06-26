<?php
/* @var $this Controller
 * @var $links InnerLink[]
 */
?><div class="donors">

    <div class="block-title">Доноры</div>

    <ul>
        <?php foreach ($links as $link): ?>
            <li><a target="_blank" href="<?=$link->page->url ?>"><?=$link->page->url ?></a></li>
        <?php endforeach; ?>
    </ul>

</div>