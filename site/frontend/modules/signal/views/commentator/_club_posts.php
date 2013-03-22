<?php
/* @var $this CommentatorController
 * @var CommunityContent[] $club_posts
 */

$progress = ($this->commentator->clubPostsCount() == 0) ? 0 : round(100 * $this->commentator->clubPostsCount() / $this->commentator->getClubPostsLimit());
$tasks = SeoTask::getCommentatorActiveTasks(1);
?>
<span class="item-title">2. Написать <?=$this->commentator->getClubPostsLimit() ?> <?=HDate::GenerateNoun(array('запись','записи','записей'), $this->commentator->getClubPostsLimit()) ?> в клубы</span><span class="progress"><span style="width:<?=$progress?>%"></span></span>
<ul>
    <?php foreach ($tasks as $task): ?>
        <?php if ($task !== null && $task->status == SeoTask::STATUS_CLOSED): ?>
        <?php $article = $task->article->getArticle() ?>
        <li>
            <?php if ($article !== null):?>
                <b>По подсказке:</b>
                <a href="<?=$task->article->url ?>" target="_blank"><?= $article->title ?></a>
                <span class="done"><i class="icon"></i>Сделано</span>
                <span class="date"><?=Yii::app()->dateFormatter->format('dd MMM yyyy, HH:mm', strtotime($article->created)) ?></span>
            <?php else: ?>
                Ошибка, статья не найдена <?php var_dump($task->article->attributes) ?>
            <?php endif ?>
        </li>
        <?php else: ?>
            <?php $this->renderPartial('_hint', array('task' => $task, 'block'=>1)) ?>
        <?php endif ?>
    <?php endforeach; ?>

    <?php if (empty($tasks)) $this->renderPartial('_hint', array('task' => null, 'block'=>1)) ?>
</ul>