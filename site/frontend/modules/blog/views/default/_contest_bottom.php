<?php $randomParticipants = $data->contestWork->getOtherParticipants(2, 2); if ($randomParticipants): ?>
    <div class="article-contest-conversion">
        <div class="article-contest-conversion_t">
            Другие участники конкурса
        </div>
        <div class="article-contest-conversion_hold">
            <?php foreach ($randomParticipants as $contestWork): ?>
                <?php $this->renderPartial('application.modules.blog.views.default._b_article', array('model' => $contestWork->content, 'showLikes' => false)); ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<div class="b-contest-advert">
    <div class="b-contest-advert_ico">
        <img src="/images/contest/club/<?=$data->contestWork->contest->cssClass?>/medium.png" alt="" class="b-contest-advert_img">
    </div>
    <div class="b-contest-advert_hold">
        <div class="b-contest-advert_t">КОНКУРС</div>
        <div class="b-contest-advert_name"><?=$data->contestWork->contest->title?></div>
        <?php if ($data->contestWork->contest->status == CommunityContest::STATUS_ACTIVE): ?>
            <a href="<?=$data->contestWork->contest->getExternalParticipateUrl()?>" class="btn-green btn-h46<?php if (Yii::app()->user->isGuest): ?> fancy<?php endif; ?>">Принять участие!</a>
        <?php endif; ?>
    </div>
</div>