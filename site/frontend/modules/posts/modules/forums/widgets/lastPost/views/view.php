<?php
/**
 * @var \site\frontend\modules\posts\models\Content[] $posts
 * @var \site\frontend\components\api\models\User[] $users
 */
?>

<div class="latest-posts">
    <div class="widget-top">
        <div class="heading-wd">Последние посты</div>
    </div>
    <ul>
        <?php foreach ($posts as $post): ?>
        <li class="widget_item">
            <div class="widget_latest-posts_heading">
                <a href="<?=$post->url?>"><?=$post->title?></a>
                <div class="icons-meta">
                    <a href="<?=$post->url?>#commentsList" class="icons-meta_comment"><span class="icons-meta_tx"><?=$this->createWidget('site\frontend\modules\comments\widgets\CommentWidget', array('model' => array(
                                'entity' => $post->originService == 'oldBlog' ? 'BlogContent' : $post->originEntity,
                                'entity_id' => $post->originEntityId,
                            )))->count?></span></a>
                    <div class="icons-meta_view"><span class="icons-meta_tx"><?=Yii::app()->getModule('analytics')->visitsManager->getVisits($post->url)?></span></div>
                </div>
            </div>
            <div class="widget_latest-posts_user live-user">
                <a href="<?=$users[$post->authorId]->profileUrl?>" class="ava ava__small ava__<?=($users[$post->authorId]->gender) ? 'male' : 'female'?>">
                    <?php if ($users[$post->authorId]->avatarUrl): ?>
                        <img alt="" src="<?=$users[$post->authorId]->avatarUrl?>" class="ava_img">
                    <?php endif; ?>
                </a>
                <div class="username">
                    <a href="<?=$users[$post->authorId]->profileUrl?>"><?=$users[$post->authorId]->fullName?></a>
                    <?=HHtml::timeTag($post, array('class' => 'tx-date'))?>
                </div>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php if (false): ?>
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
<?php endif; ?>