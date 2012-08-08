<div class="box list-item">
    <div class="box-title"><?=($users[$action->user_id]->gender == 1) ? 'Изменил' : 'Изменила'?> статус</div>
    <div class="user-status">
        <div class="date"><?=Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", $action->data['created'])?></div>
        <p><?=$action->data['text']?></p>
    </div>
</div>