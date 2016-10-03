<?php
use site\frontend\modules\comments\modules\contest\components\ContestHelper;

/**
 * @var \site\frontend\modules\comments\modules\contest\models\CommentatorsContestComment $data
 */

/**
 * @var \site\frontend\modules\comments\models\Comment|\Comment $comment
 */
$comment = $data->comment;
?>

<!-- b-article-->
<article class="b-article b-article__list clearfix b-article-qa">
    <div class="b-article_cont clearfix">
        <div class="b-article_header clearfix">
            <div class="float-l">
                <!-- ava--><a href="<?= $comment->author->getUrl() ?>" class="ava ava__female ava__small-xxs ava__middle-xs ava__middle-sm-mid "><span class="ico-status <?=$comment->author->online ? 'ico-status__online' : ''?>"></span><img alt="" src="<?= $comment->author->getAvatarUrl() ?>" class="ava_img"></a><a href="<?= $comment->author->getUrl() ?>" class="b-article_author"><?= $comment->author->getFullName() ?></a>
                <time pubdate="1957-10-04" class="tx-date"><?= HHtml::timeTag($comment, array('class' => 'tx-date'), null); ?></time>
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
                                        <p><?= $comment->text ?></p>
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
                        <!-- ava--><a href="<?= $comment->post->author->getUrl() ?>" class="ava ava__female ava__small"><span class="ico-status <?=$comment->post->author->online ? 'ico-status__online' : ''?>"></span><img alt="" src="<?= $comment->post->author->getAvatarUrl() ?>" class="ava_img"></a><a href="<?= $comment->post->author->getUrl() ?>" class="b-post-anonce-s_author"><?= $comment->post->author->getFullName() ?></a>
                        <time pubdate="1957-10-04" class="tx-date"><?= HHtml::timeTag($comment->post, array('class' => 'tx-date'), null); ?></time>
                    </div><a href="<?= ContestHelper::getValidPostUrl($comment->post->url) ?>" class="b-post-anonce-s_t"><?= $comment->post->title ?></a>
                </div>
            </div>
            <!-- /b-post-anonce-s-->
        </div>
    </div>
</article>