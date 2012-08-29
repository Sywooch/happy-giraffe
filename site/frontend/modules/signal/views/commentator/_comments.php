<?php
/* @var $this HController
 * @var int $comments_count
 */
$progress = ($comments_count == 0)?0:round(100*$comments_count/CommentatorWork::COMMENTS_COUNT);
?>
<span class="item-title">3. Написать <?=CommentatorWork::COMMENTS_COUNT ?> комментариев</span><span class="done"><i class="icon"></i><?=$comments_count ?></span><span class="progress"><span style="width:<?=$progress?>%"></span></span>
<ul>
    <li>
        <span class="next">NEXT</span>
        <a href="">Дети и кондиционер, совместимы ли</a>
        <a href="" class="btn-green-small">Ok</a>
        <a href="" class="pseudo skip">Пропустить</a>
    </li>
</ul>