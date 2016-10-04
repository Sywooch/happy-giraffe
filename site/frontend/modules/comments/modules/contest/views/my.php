<?php
use site\frontend\modules\comments\modules\contest\components\ContestHelper;

/**
 * @var site\frontend\modules\comments\modules\contest\models\CommentatorsContestComment[] $comments
 * @var site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant $participant
 * @var int $commentsCount
 * @var int $count
 */
$this->pageTitle = $this->contest->name . ' - Мои баллы';
$cs = Yii::app()->clientScript;
$cs->registerAMD('contestCommentsIndex', array('kow'));
?>

<?php if (!\Yii::app()->user->isGuest): ?>
    <?php $this->widget('site\frontend\modules\comments\modules\contest\widgets\MyStatWidget'); ?>
<?php endif; ?>
<div class="b-contest-task b-contest__block textalign-c">
    <div class="b-contest__title">Мои баллы</div>
    <div class="b-contest-winner__container textalign-l">
        <?php foreach ($comments as $comment): ?>
        <article class="b-article b-article__list clearfix b-article-qa">
            <div class="b-article_cont clearfix">
                <div class="b-article_header clearfix">
                    <div class="float-l">
                        <!-- ava--><a href="<?= $participant->user->getUrl() ?>" class="ava ava__female ava__small-xxs ava__middle-xs ava__middle-sm-mid "><span class="ico-status <?=$participant->user->online ? 'ico-status__online' : ''?>"></span><img alt="" src="<?= $participant->user->getAvatarUrl() ?>" class="ava_img"></a><a href="<?= $participant->user->getUrl() ?>" class="b-article_author"><?= $participant->user->getFullName() ?></a>
                        <time pubdate="1957-10-04" class="tx-date"><?= HHtml::timeTag($comment->comment, array('class' => 'tx-date'), null); ?></time>
                    </div>
                    <div class="float-r">
                        <div class="<?=$comment->points > 1 ? 'b-article__num_mod' : 'b-article__num' ?>"><span>+<?= $comment->points ?></span></div>
                    </div>
                </div>
                <div class="b-article_in clearfix">
                    <div class="comments comments__buble comments__anonce">
                        <div class="comments_hold">
                            <div class="comments_li comments_li__lilac">
                                <div class="comments_i clearfix">
                                    <div class="comments_frame">
                                        <div class="comments_cont">
                                            <div class="wysiwyg-content">
                                                <p><?= $comment->comment->text ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="b-post-anonce-s">
                        <div class="b-post-anonce-s_hold">
                            <div class="b-post-anonce-s_header clearfix">
                                <!-- ava--><a href="<?= $comment->comment->post->author->getUrl() ?>" class="ava ava__female ava__small"><span class="ico-status <?=$comment->comment->post->author->online ? 'ico-status__online' : ''?>"></span><img alt="" src="<?= $comment->comment->post->author->getAvatarUrl() ?>" class="ava_img"></a><a href="<?= $comment->comment->post->author->getUrl() ?>" class="b-post-anonce-s_author"><?= $comment->comment->post->author->getFullName() ?></a>
                                <time pubdate="1957-10-04" class="tx-date"><?= HHtml::timeTag($comment->comment->post, array('class' => 'tx-date'), null); ?></time>
                            </div><a href="<?= ContestHelper::getValidPostUrl($comment->comment->post->url) ?>" class="b-post-anonce-s_t"><?= $comment->comment->post->title ?></a>
                        </div>
                    </div>
                    <!-- /b-post-anonce-s-->
                </div>
            </div>
        </article>
        <?php endforeach; ?>

        <?php if ($commentsCount > $count): ?>
            <div class="textalign-c"><a href="<?= \Yii::app()->createUrl('/comments/contest/default/my', array('count' => $count + 30)) ?>" class="b-contest__link">Показать еще 30</a></div>
        <?php endif; ?>
    </div>
</div>
