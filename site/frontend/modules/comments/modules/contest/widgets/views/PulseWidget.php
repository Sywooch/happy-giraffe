<?php
/**
 * @var \site\frontend\modules\comments\models\Comment[] $comments
 * @var int $limit
 */
?>
<div class="b-contest__title textalign-c">Пульс конкурса</div>
<div class="b-main_cont-contest">
    <?php foreach ($this->comments as $comment):?>
    <!-- Добавлен комментарий-->
    <!-- b-article-->
    <article class="b-article b-article__list clearfix b-article-qa">
        <div class="b-article_cont clearfix">
            <div class="b-article_header clearfix">
                <div class="float-l">
                    <!-- ava--><a href="<?= $comment->author->getUrl() ?>" class="ava ava__female ava__small-xxs ava__middle-xs ava__middle-sm-mid "><span class="ico-status <?=$comment->author->online ? 'ico-status__online' : ''?>"></span><img alt="" src="<?= $comment->author->getAvatarUrl()?>" class="ava_img"></a><a href="#" class="b-article_author"><?= $comment->author->getFullName() ?></a>
                    <time pubdate="1957-10-04" class="tx-date"><?= $comment->created ?></time>
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
                            <!-- ava--><a href="<?= $comment->post->author->getUrl() ?>" class="ava ava__female ava__small"><span class="ico-status <?=$comment->post->author->online ? 'ico-status__online' : ''?>"></span><img alt="" src="<?= $comment->post->author->getAvatarUrl() ?>" class="ava_img"></a><a href="#" class="b-post-anonce-s_author"><?= $comment->post->author->getFullName(); ?></a>
                            <time pubdate="1957-10-04" class="tx-date"><?= $comment->post->dtimeCreate ?></time>
                        </div><a href="<?= $comment->post->url ?>" class="b-post-anonce-s_t"><?= $comment->post->title ?></a>
                    </div>
                </div>
                <!-- /b-post-anonce-s-->
            </div>
        </div>
    </article>
    <?php endforeach; ?>
    <!-- /b-article-->

    <div class="textalign-c"><a href="<?= \Yii::app()->createUrl('/comments/contest/default/pulse'); ?>" class="b-contest__link">Весь пульс</a></div>
</div>

