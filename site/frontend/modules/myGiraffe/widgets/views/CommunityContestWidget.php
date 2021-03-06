<?php
/**
 * @var CommunityContest $contest
 */
?>

<div class="b-article-conversion b-article-conversion__contest b-article-conversion__<?=$contest->cssClass?> clearfix">
    <a href="javascript:void(0)" class="a-pseudo b-article-conversion_hide" onclick="$(this).parent().hide();">Скрыть</a>
    <div class="b-article-conversion_tx-top">Внимание! С 20 ноября стартовал <br>конкурс рассказов о вашей беременности!     </div>
    <div class="heading-title textalign-c clearfix"> <img src="/images/contest/club/<?=$contest->cssClass?>/small.png" alt=""><?=$contest->title?></div>
    <div class="textalign-c font-middle">
        <a href="<?=$contest->url?>">Участники конкурса (<?=$contest->contestWorksCount?>)</a>
    </div>

    <?php $randomParticipants = $contest->getRandomParticipants(2); foreach ($randomParticipants as $participant): ?>
        <?php Yii::app()->controller->renderPartial('application.modules.blog.views.default._b_article', array('model' => $participant->content, 'showLikes' => true)); ?>
    <?php endforeach; ?>
    <div class="clearfix">
        <div class="b-article-conversion_tx-bottom">Расскажите вашу версию события!  </div>
        <div class="textalign-c margin-b20">
            <a href="<?=$contest->getExternalParticipateUrl()?>" class="btn-green btn-h46">Принять участие!</a>
        </div>
    </div>
</div>