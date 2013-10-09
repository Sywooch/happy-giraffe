<?php
/**
 * @var CommunityContestWork @contestWork
 */
?>

<div class="contest-meter">
    <div class="contest-meter_count">
        <div class="contest-meter_count-num contest-counter"><?=$contestWork->rate?></div>
        <div class="contest-meter_count-tx"><?=Str::GenerateNoun(array('балл', 'балла', 'баллов'), $contestWork->rate)?></div>
    </div>
    <a href="javascript:void(0)" class="contest-meter_a-vote" onclick="$(this).next().toggleClass('display-b')">Голосовать</a>
    <div class="contest-meter_vote">
        <div class="contest-meter_vote-tx">Вы можете проголосовать за участника нажав на кнопки соцсетей</div>
        <div class="contest-meter_vote-hold">
            <div class="like-block fast-like-block">

                <div class="box-1">

                    <?php
                    Yii::app()->eauth->renderWidget(array(
                        'action' => '/ajax/socialVote',
                        'params' => array(
                            'entity' => get_class($contestWork),
                            'entity_id' => $contestWork->id,
                            'model' => $contestWork
                        ),
                        'mode' => 'vote',
                    ));
                    ?>

                </div>

            </div>

        </div>
    </div>
</div>