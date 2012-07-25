<div class="box list-item">
    <div class="box-title">Изменил статус</div>
    <div class="user-status">
        <div class="date"><?=Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", $action->data['created'])?></div>
        <p><?=$action->data['text']?></p>
    </div>
</div>