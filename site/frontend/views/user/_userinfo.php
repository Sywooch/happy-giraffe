<div class="clearfix user-info-big">
    <?php
        $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
            'user' => $user,
            'location' => false,
            'friendButton' => true,
        ));
    ?>
    <div class="user-fast-nav">
        <ul class="clearfix">
            <?php if ($this->uniqueId != 'user/profile'): ?>
            <li><?=CHtml::link('Анкета', array('user/profile', 'user_id' => $user->id))?></li>
            <?php endif; ?>
            <?php if ($this->uniqueId != 'blog/list'): ?>
            <li><?=CHtml::link('Блог', array('blog/list', 'user_id' => $user->id))?></li>
            <?php endif; ?>
            <?php if ($this->uniqueId != 'albums/user'): ?>
            <li><?=CHtml::link('Фото', array('albums/user', 'id' => $user->id))?></li>
            <?php endif; ?>
            <?php if ($this->uniqueId != 'user/activity'): ?>
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
    <?php if ($user->status): ?>
    <div class="text-status">
        <p><?=$user->status->text?></p>
        <span class="tale"></span>
    </div>
    <?php endif; ?>
</div>