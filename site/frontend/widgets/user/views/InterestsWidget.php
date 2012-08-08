<div class="user-interests">
    <div class="box-title">Интересы<?php if ($this->isMyProfile): ?><?=CHtml::link('', array('/ajax/interestsForm'), array('class' => 'interest-add fancy'))?><?php endif; ?></div>

    <ul>
        <?php foreach ($this->interests as $category): ?>
        <li>
            <div class="interest-cat">
                <span class="img"><img src="/images/interest_icon_<?=$category->id?>.png" /></span>
                <span class="text"><?=$category->title?></span>
            </div>
            <ul>
                <?php foreach ($category->interests as $interest): ?>
                    <li><a class="interest"><?=$interest->title?><span><?=$interest->usersCount?></span></a></li>
                <?php endforeach; ?>
            </ul>
        </li>
        <?php endforeach; ?>

    </ul>
</div>

<?php if (false): ?>
    <div class="user-interests">
        <div class="box-title">
            Интересы
            <?php if(!Yii::app()->user->isGuest && Yii::app()->user->id == $this->user->id): ?>
                <?php echo CHtml::link('', array('/ajax/interestsForm'), array('class' => 'interest-add fancy')); ?>
            <?php endif; ?>
        </div>
        <ul id="user_interests_list">
            <?php foreach ($user->interests as $interest): ?>
                <li><span class="interest selected <?php echo $interest->category->css_class ?>"><?php echo $interest->title ?></span></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>