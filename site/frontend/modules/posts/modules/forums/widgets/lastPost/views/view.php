<?php
/**
 * @var \site\frontend\modules\posts\models\Content[] $posts
 * @var \site\frontend\components\api\models\User[] $users
 */
?>

<ul>
<?php foreach ($posts as $post): ?>
    <li>
        <p><?=CHtml::link($post->title, $post->url)?></p>
        <p><?=Yii::app()->getModule('analytics')->visitsManager->getVisits($post->url)?></p>
        <p><?=$this->createWidget('site\frontend\modules\comments\widgets\CommentWidget', array('model' => array(
                'entity' => $post->originService == 'oldBlog' ? 'BlogContent' : $post->originEntity,
                'entity_id' => $post->originEntityId,
            )))->count?></p>
        <p><img src="<?=$users[$post->authorId]->avatarUrl?>"><?=CHtml::link($users[$post->authorId]->fullName, $users[$post->authorId]->profileUrl)?></p>
    </li>
<?php endforeach; ?>
</ul>