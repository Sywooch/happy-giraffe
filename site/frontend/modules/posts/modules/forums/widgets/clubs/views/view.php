<?php
/**
 * @var \CommunitySection[] $sections
 * @var \site\frontend\modules\posts\models\Content[] $posts
 * @var \site\frontend\components\api\models\User[] $users
 */
?>

<?php foreach ($sections as $section): ?>
    <h1><?=$section->title?></h1>
    <ul>
        <?php foreach ($section->clubs as $club): ?>
            <li>
                <p><?=$club->title?></p>
                <p><?=$club->description?></p>
                <p><?=\site\frontend\modules\community\helpers\StatsHelper::getPosts($club->id)?></p>
                <p><?=\site\frontend\modules\community\helpers\StatsHelper::getComments($club->id)?></p>
                <?php if (isset($posts[$club->id])): ?>
                    <p><?=CHtml::link($posts[$club->id]->title, $posts[$club->id]->url)?></p>
                    <p><?=CHtml::link($users[$posts[$club->id]->authorId]->fullName, $users[$posts[$club->id]->authorId]->profileUrl)?></p>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endforeach; ?>