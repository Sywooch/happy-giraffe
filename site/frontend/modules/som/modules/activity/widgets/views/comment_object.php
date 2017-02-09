<?php

use site\frontend\modules\som\modules\activity\widgets\ActivityWidget;

/*@var $data \site\frontend\modules\som\modules\qa\models\QaAnswer */

?>

<div class="b-article_in clearfix">
    <div class="comments comments__buble comments__anonce">
        <div class="comments_hold">
            <div class="comments_li comments_li__lilac">
                <div class="comments_i clearfix">
                    <div class="comments_frame">
                        <div onclick="location.href='<?=$data->question->url?>'" class="comments_link">
                            <div class="comments_cont">
                                <div class="wysiwyg-content">
                                    <?= $data->text ?>
                                </div>
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
                <a href="<?= $user->profileUrl ?>" class="ava ava__<?= $user->gender ? '' : 'fe' ?>male ava__small">
                    <span class="ico-status ico-status__online"></span>
                    <img alt="" src="<?= $user->avatarUrl ?>" class="ava_img">
                </a>
                <a href="<?= $user->profileUrl ?>" class="b-post-anonce-s_author"><?= $user->fullName ?></a>
                <?= HHtml::timeTagByOptions($data->dtimeCreate, array('id' => 'activityCommentTime' . $data->id, 'class' => 'tx-date')) ?>
            </div>
            <a href="<?=$data->question->url?>" class="b-post-anonce-s_t"><?=$data->question->title?></a>
        </div>
    </div>
</div>