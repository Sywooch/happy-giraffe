<?php

use site\frontend\modules\som\modules\activity\widgets\ActivityWidget;

$user = $this->getUserInfo($data->userId);
?>
<article class="b-article b-article__list clearfix">
    <div class="b-article_cont clearfix">
        <div class="b-article_header clearfix">
            <div class="float-l">
                <!-- ava-->
                <a href="<?= $user->profileUrl ?>" class="ava ava__<?= $user->gender ? '' : 'fe' ?>male ava__small-xxs ava__middle-xs ava__middle-sm-mid ">
                    <span class="ico-status ico-status__online"></span>
                    <img alt="" src="<?= $user->avatarUrl ?>" class="ava_img">
                </a>
                <a href="<?= $user->profileUrl ?>" class="b-article_author"><?= $user->fullName ?></a>
                <?= HHtml::timeTag($data, array('class' => 'tx-date'), null); ?>
            </div>
        </div>
        <?php $this->render(ActivityWidget::$types[$data->typeId][1], array('data' => $data)); ?>
    </div>
</article>