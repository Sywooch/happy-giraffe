<?php
//15: 'answer',
//16: 'like',
//17: 'answer_by_pediatrician',
//18: 'answer_to_additional',
//19: 'additional',
//20: 'reply_in_question'
$tmpl = [
    15 => [
        'type' => 'answer',
        'text' => 'ответил на ваш вопрос',
    ],
    16 => [
        'type' => 'like',
        'text' => 'поставил Спасибо вашему ответу',
    ],
    17 => [
        'type' => 'answer_by_pediatrician',
        'text' => 'ответил на ваш вопрос',
    ],
    18 => [
        'type' => 'answer_to_additional',
        'text' => 'ответил на ваш вопрос',
    ],
    19 => [
        'type' => 'additional',
        'text' => 'ответил на ваш вопрос',
    ],
    20 => [
        'type' => 'reply_in_question',
        'text' => 'ответил на ваш комментарий',
    ],

];
$urlAva = $data->user->avatarUrl?$data->user->avatarUrl:'/app/builds/static/img/assets/ava/ava-default.svg';
$spec = false;
if(!empty($data->user->specialistProfile)){
    $spec = $data->user->specialistProfile->specialization;
}
?>
<a class="notification-list-item" href="<?=$model->entity->url?>">
    <div class="notification-list-item-col">
        <div class="notification-list-item-ava" style="background-image: url('<?=$urlAva?>')">
            <div class="notification-list-item-icon notification-list-item-icon__<?=$tmpl[$model->type]['type']?>"></div>
        </div>
    </div>
    <div class="notification-list-item-col">
        <div class="notification-list-item-text">
            <span class="notification-list-item-text__blue"><?=$data->user->fullName?></span>
            <?php if($spec) {?>
            <span class="notification-list-item-text__red"><?=$spec?></span>
            <?php } ?>
            <span class="notification-list-item-text__black"><?=$tmpl[$model->type]['text']?></span>
        </div>
        <div class="notification-list-item-own"><?=$data->shortTitle?></div>
        <div class="notification-list-item__time"><?=HHtml::timeTagByOptions($model->dtimeUpdate, ['class' => 'tx-date','id'=>$data->id])?></div>
    </div>
</a>