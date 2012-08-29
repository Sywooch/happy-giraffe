<?php
/* @var $this CommentatorController
 * @var CommunityContent[] $club_posts
 */
$filled = array();
foreach($club_posts as $club_post)
    $filled[] = $club_post->rubric->community_id;

$progress = (count($club_posts) == 0)?0:round(100*count($club_posts)/CommentatorWork::CLUB_POSTS_COUNT);
?>
<span class="item-title">2. Написать <?=CommentatorWork::CLUB_POSTS_COUNT ?> <?=HDate::GenerateNoun(array('запись','записи','записей'), CommentatorWork::CLUB_POSTS_COUNT) ?> в клубы</span><span class="progress"><span style="width:<?=$progress?>%"></span></span>

<ul>
    <?php foreach ($this->commentator->communities() as $community): ?>
        <li>
            <a href="http://www.happy-giraffe.ru/community/<?= $community->id ?>/forum/"><?= $community->title ?></a>
            <?php if (in_array($community->id, $filled)):?>
            <?php foreach($club_posts as $club_post) if ($club_post->rubric->community_id == $community->id) {$post = $club_post;break;}?>
                <span class="done"><i class="icon"></i>Сделано</span>
                <span class="date"><?=Yii::app()->dateFormatter->format('dd MMM yyyy, HH:mm', strtotime($post->created)) ?></span>
            <?php endif ?>
        </li>
    <?php endforeach; ?>
</ul>