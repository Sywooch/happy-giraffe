<?php
/* @var $this CommentatorController
 */

$comments_count = $this->commentator->getCurrentDay()->comments;
$progress = ($comments_count == 0)?0:round(100*$comments_count/CommentatorWork::COMMENTS_COUNT);
?>
<span class="item-title">3. Написать <?=CommentatorWork::COMMENTS_COUNT ?> комментариев</span><span class="done"><i class="icon"></i><?=$comments_count ?></span><span class="progress"><span style="width:<?=$progress?>%"></span></span>
<ul>
    <li>
        <span class="next">NEXT</span>
        <?=$this->commentator->nextComment() ?>
<!--        <a href="" class="btn-green-small">Ok</a>-->
        <a href="javascript:;" class="pseudo skip" onclick="CommentatorPanel.skip();">Пропустить</a>
    </li>
</ul>