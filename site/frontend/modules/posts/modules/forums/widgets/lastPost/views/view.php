<ul>
<?php foreach ($this->posts as $post): ?>
    <li>
        <p><?=CHtml::link($post->title, $post->url)?></p>
        <p><?=Yii::app()->getModule('analytics')->visitsManager->getVisits($post->url)?></p>
        <p><?=$this->createWidget('site\frontend\modules\comments\widgets\CommentWidget', array('model' => array(
                'entity' => $post->originService == 'oldBlog' ? 'BlogContent' : $post->originEntity,
                'entity_id' => $post->originEntityId,
            )))->count?></p>
        <p><img src="<?=$this->getUser($post->authorId)->avatarUrl?>"><?=CHtml::link($this->getUser($post->authorId)->fullName, $this->getUser($post->authorId)->profileUrl)?></p>
    </li>
<?php endforeach; ?>
</ul>