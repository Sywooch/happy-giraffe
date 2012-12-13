<?php
/* @var $this CommentatorController
 * @var CommunityContent[] $club_posts
 */
$club = $this->commentator->getCurrentClubId();
$community = Community::model()->findByPk($club);

$post = null;
foreach($club_posts as $club_post){
    if ($club_post->rubric->community_id == $club)
        $post = $club_post;
}

$progress = ($this->commentator->clubPostsCount() == 0) ? 0 : round(100 * $this->commentator->clubPostsCount() / $this->commentator->getClubPostsLimit());
$tasks = SeoTask::getCommentatorActiveTasks(1);
?>
<span class="item-title">2. Написать <?=$this->commentator->getClubPostsLimit() ?> <?=HDate::GenerateNoun(array('запись','записи','записей'), $this->commentator->getClubPostsLimit()) ?> в клубы</span><span class="progress"><span style="width:<?=$progress?>%"></span></span>
<ul>
    <li>
        <a href="http://<?=$_SERVER['SERVER_NAME'] ?>/community/<?= $community->id ?>/forum/" target="_blank"><?= $community->title ?></a>
        <?php if ($post !== null):?>
            <span class="done"><i class="icon"></i>Сделано</span>
            <span class="date"><?=Yii::app()->dateFormatter->format('dd MMM yyyy, HH:mm', strtotime($post->created)) ?></span>
        <?php endif ?>
    </li>
    <?php foreach ($tasks as $task): ?>
        <?php if ($task !== null && $task->status == SeoTask::STATUS_CLOSED): ?>
        <li>
            <b>По подсказке:</b>
            <a href="<?=$task->article->url ?>" target="_blank"><?= $task->article->getArticleTitle() ?></a>
            <span class="done"><i class="icon"></i>Сделано</span>
            <span class="date"><?=Yii::app()->dateFormatter->format('dd MMM yyyy, HH:mm', strtotime($task->article->getArticle()->created)) ?></span>
        </li>
        <?php else: ?>
            <?php $this->renderPartial('_hint', array('task' => $task, 'block'=>1)) ?>
        <?php endif ?>
    <?php endforeach; ?>

    <?php if (empty($tasks)) $this->renderPartial('_hint', array('task' => null, 'block'=>1)) ?>
</ul>