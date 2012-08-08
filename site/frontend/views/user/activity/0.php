<div class="user-mood list-item">
    <?=($users[$action->user_id]->gender == 1) ? 'Изменил' : 'Изменила'?> настроение <img id="userMood" src="/images/widget/mood/<?=$action->data['mood_id']?>.png">
</div>