<?php
/**
 * @var CommunityContest $contest
 */
?>

<div class="article-contest-member article-contest-member__<?=$contest->cssClass?>">
    <div class="article-contest-member_hold">
        <img src="/images/contest/club/<?=$contest->cssClass?>/small.png" alt="" class="article-contest-member_ico">
        <div class="article-contest-member_tx">
            Запись участвует в конкурсе
            <a href="<?=$contest->url?>"><?=$contest->title?></a>
        </div>
    </div>
</div>