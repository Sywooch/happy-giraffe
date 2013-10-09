<div class="sharelink-friends">
    <div class="clearfix">
        <div class="sharelink-friends_t">Cсылка</div>
        <input type="text" class="sharelink-friends_itx" value="<?=$data->getUrl(false, true)?>" onclick="$(this).select();" style="width: 450px;">

    </div>
</div>

<div class="article-contest">
    <div class="article-contest_col1">
        <img src="/images/contest/club/pets1/small.png" alt="">
        <div class="article-contest_name">Запись участвует в конкурсе <br>
            <a href="<?=$data->contestWork->contest->getUrl()?>"><?=$data->contestWork->contest->title?></a>
        </div>
    </div>
    <div class="article-contest_count">
        <div class="article-contest_count-num contest-counter"><?=$data->contestWork->rate?></div>
        <div class="article-contest_count-desc"><?=Str::GenerateNoun(array('балл', 'балла', 'баллов'), $data->contestWork->rate)?></div>
    </div>
    <div class="article-contest_col3">
        Вы можете проголосовать за участника нажав на кнопки соцсетей
    </div>
</div>
<div class="like-block fast-like-block">

    <div class="box-1">
        <?php
        Yii::app()->eauth->renderWidget(array(
            'action' => '/ajax/socialVote',
            'params' => array(
                'entity' => get_class($data->contestWork),
                'entity_id' => $data->contestWork->id,
                'model' => $data->contestWork
            ),
            'mode' => 'vote',
        ));
        ?>

    </div>

</div>
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
        <img src="/images/contest/club/pets1/medium.png" alt="" class="b-contest-advert_img">
    </div>
    <div class="b-contest-advert_hold">
        <div class="b-contest-advert_t">КОНКУРС</div>
        <div class="b-contest-advert_name"><?=$data->contestWork->contest->title?></div>
        <a href="<?=$data->contestWork->contest->getExternalParticipateUrl()?>" class="btn-green btn-h46">Принять участие!</a>
    </div>
</div>