<div class="user-fast-nav">
    <ul class="clearfix">
        <?php if ($this->id != 'user' || $this->action->id != 'profile'): ?>
        <li><?=CHtml::link('Анкета', array('user/profile', 'user_id' => $user->id))?></li>
        <?php endif; ?>
        <?php if ($this->id != 'blog' || $this->action->id != 'list'): ?>
        <li><?=CHtml::link('Блог', array('blog/list', 'user_id' => $user->id))?></li>
        <?php endif; ?>
        <?php if ($this->id != 'albums' || $this->action->id != 'user'): ?>
        <li><?=CHtml::link('Фото', array('albums/user', 'id' => $user->id))?></li>
        <?php endif; ?>
        <?php if ($this->id != 'user' || $this->action->id != 'activity'): ?>
        <li><?=CHtml::link('Что нового', array('user/activity', 'user_id' => $user->id, 'type' => 'my'))?></li>
        <?php endif; ?>
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