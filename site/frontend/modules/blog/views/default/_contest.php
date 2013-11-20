<?php if ($data->author_id == Yii::app()->user->id): ?>
    <div class="sharelink-friends">
        <div class="clearfix">
            <div class="sharelink-friends_t">Cсылка</div>
            <input type="text" class="sharelink-friends_itx" value="<?=$data->getUrl(false, true)?>" onclick="$(this).select();" style="width: 450px;">

        </div>
    </div>
<?php endif; ?>

<div class="article-contest">
    <div class="article-contest_col1">
        <img src="/images/contest/club/<?=$data->contestWork->contest->cssClass?>/small.png" alt="">
        <div class="article-contest_name">Запись участвует в конкурсе <br>
            <a href="<?=$data->contestWork->contest->getUrl()?>"><?=$data->contestWork->contest->title?></a>
        </div>
    </div>
    <div class="article-contest_count">
        <div class="article-contest_count-num contest-counter"><?=$data->contestWork->rate?></div>
        <div class="article-contest_count-desc"><?=Str::GenerateNoun(array('балл', 'балла', 'баллов'), $data->contestWork->rate)?></div>
    </div>
    <div class="article-contest_col3">
        <?=($data->contestWork->contest->status == CommunityContest::STATUS_ACTIVE) ? 'Вы можете проголосовать за участника нажав на кнопки соцсетей' : 'Конкурс завершен. Идет подсчет голосов.'?>
    </div>
    <?php if ($data->contestWork->contest->status == CommunityContest::STATUS_ACTIVE): ?>
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
    <?php endif; ?>
</div>