<div class="user-fast-nav">
    <ul class="clearfix">
        <li><?=CHtml::link('Анкета', array('user/profile', 'user_id' => $user->id))?></li>
        <li><?=CHtml::link('Блог', array('blog/list', 'user_id' => $user->id))?></li>
        <?php if (Yii::app()->user->id == $user->id && isset($showFamily)):?>
            <li><?=CHtml::link('Семья', array('/family'))?></li>
        <?php endif ?>
        <li><?=CHtml::link('Фото', array('albums/user', 'id' => $user->id))?></li>
        <li>
            <span class="drp-list">
                <a href="javascript:void(0)" class="more" onclick="$(this).next().toggle(); return false;">Еще</a>
                <ul style="display: none;">
                    <li><?=CHtml::link('Друзья', array('user/friends', 'user_id' => $user->id))?></li>
                    <li><?=CHtml::link('Клубы', array('user/clubs', 'user_id' => $user->id))?></li>
                </ul>
            </span>
        </li>
    </ul>
</div>