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