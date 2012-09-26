<?php
/* @var $this CommentatorController
 * @var CommunityContent[] $blog_posts
 */
$progress = (count($blog_posts) == 0)?0:round(100*count($blog_posts)/$this->commentator->getBlogPostsLimit());
?>

<span class="item-title">1. Написать <?=$this->commentator->getBlogPostsLimit() <= 1 ? '':$this->commentator->getBlogPostsLimit() ?> <?=HDate::GenerateNoun(array('запись','записи','записей'), $this->commentator->getBlogPostsLimit()) ?> в блог</span><span class="progress"><span style="width:<?=$progress ?>%"></span></span>
<ul>
    <?php
foreach ($blog_posts as $post): ?>
    <li>
        <?=CHtml::link($post->title, $post->url, array('target' => '_blank')) ?>
        <span class="done"><i class="icon"></i>Сделано</span>
        <span
            class="date"><?=Yii::app()->dateFormatter->format('dd MMM yyyy, HH:mm', strtotime($post->created)) ?></span>
    </li>
    <?php endforeach; ?>
</ul>
