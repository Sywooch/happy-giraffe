<?php
/**
 * @var CommunityContestWork $contestWork
 */
?>

<div class="contest-meter">
    <div class="contest-meter_count">
        <div class="contest-meter_count-num contest-counter"><?=$model->contestWork->rate?></div>
        <div class="contest-meter_count-tx"><?=Str::GenerateNoun(array('балл', 'балла', 'баллов'), $model->contestWork->rate)?></div>
    </div>
    <?php if ($model->contestWork->contest->status == CommunityContest::STATUS_ACTIVE): ?>
        <a href="javascript:void(0)" class="contest-meter_a-vote" onclick="$(this).next().toggleClass('display-b')">Голосовать</a>
        <div class="contest-meter_vote" onmouseleave="$(this).removeClass('display-b')">
            <div class="contest-meter_vote-tx">Вы можете проголосовать за участника нажав на кнопки соцсетей</div>
            <div class="contest-meter_vote-hold">
                <div class="like-block fast-like-block">

                    <div class="box-1">

                        <?php
                        Yii::app()->eauth->renderWidget(array(
                            'action' => '/ajax/socialVote',
                            'params' => array(
                                'entity' => get_class($model->contestWork),
                                'entity_id' => $model->contestWork->id,
                                'model' => $model->contestWork
                            ),
                            'mode' => 'vote',
                        ));
                        ?>

                    </div>

                </div>

            </div>
        </div>
    <?php endif; ?>
</div>