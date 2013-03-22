<?php
/* @var $this CommentatorController
 */

$comments_count = $this->commentator->getCurrentDay()->comments;
$progress = ($comments_count == 0) ? 0 : round(100 * $comments_count / $this->commentator->getCommentsLimit());
?>
<span class="item-title">3. Написать <?=$this->commentator->getCommentsLimit() ?> комментариев</span>
<span class="done">
    <i class="icon"></i>
    <?=$comments_count ?>
</span>
<span class="progress"><span style="width:<?=$progress?>%"></span></span>
<ul>
    <li>
        <span class="next">NEXT</span>
        <?=$this->commentator->nextCommentLink() ?>
        <a href="javascript:;" class="pseudo skip" onclick="CommentatorPanel.skip();">Пропустить</a>
    </li>
</ul>