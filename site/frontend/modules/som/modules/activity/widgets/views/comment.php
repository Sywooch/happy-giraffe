<?php

use site\frontend\modules\som\modules\activity\widgets\ActivityWidget;

$dataArray = $data->getActivityData(true);

// @todo Sergey Gubarev: Нужна обертка для получения данных из Activity модели
$contentAuthor = $widget->getUserInfo($data->dataArray['content']['authorId']);

?>

<div class="b-article_in clearfix">
    <div class="comments comments__buble comments__anonce">
        <div class="comments_hold">
            <div class="comments_li comments_li__lilac">
                <div class="comments_i clearfix">
                    <div class="comments_frame">
                        <div onclick="location.href='<?=$data->dataArray['url']?>'" class="comments_link">
                            <div class="comments_cont">
                                <div class="wysiwyg-content">
                                    <?= $data->dataArray['text'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="b-post-anonce-s">
        <?php if ($data->dataArray['content']['cover']) {
            ?><div class="b-post-anonce-s_img"><img src="<?= $data->dataArray['content']['cover'] ?>" alt="Заголовок статьи"></div><?php
        }
        ?>
        <div class="b-post-anonce-s_hold">
            <div class="b-post-anonce-s_header clearfix">
                <a href="<?= $contentAuthor->profileUrl ?>" class="ava ava__<?= $contentAuthor->gender ? '' : 'fe' ?>male ava__small">
                    <span class="ico-status ico-status__online"></span>
                    <img alt="" src="<?= $contentAuthor->avatarUrl ?>" class="ava_img">
                </a>
                <a href="<?= $contentAuthor->profileUrl ?>" class="b-post-anonce-s_author"><?= $contentAuthor->fullName ?></a>
                <?= HHtml::timeTagByOptions($data->dataArray['content']['dtimeCreate'], array('id' => 'activityCommentTime' . $data->id, 'class' => 'tx-date')) ?>
            </div>
            <a href="<?= $data->dataArray['content']['url'] ?>" class="b-post-anonce-s_t"><?= $data->dataArray['content']['title'] ?></a>
        </div>
    </div>
</div>