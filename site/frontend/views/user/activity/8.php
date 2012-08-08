<div class="box user-lvl-box list-item">
    <div class="box-title"><?=($users[$action->user_id]->gender == 1) ? 'Перешёл' : 'Перешла'?> на новый уровень </div>
    <div class="user-lvl user-lvl-<?=$action->data['level_id']?>"></div>
</div>