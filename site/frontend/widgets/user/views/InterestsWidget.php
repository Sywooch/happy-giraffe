<div class="user-interests">
    <div class="box-title">Интересы<?php if ($this->isMyProfile): ?><?=CHtml::link('', array('/ajax/interestsForm'), array('class' => 'interest-add fancy'))?><?php endif; ?></div>

    <ul>
        <?php foreach ($this->interests as $category): ?>
        <ul>
            </li>
            <li>
                <div class="interest-cat">
                    <img src="/images/interest_icon_<?=$category->id?>.png" />
                </div>
                <ul class="interests-list">
                    <?php foreach ($category->interests as $i): ?>
                    <li><span class="interest"><?=$i->title?></span></li>
                    <?php endforeach; ?>
                </ul>
            </li>
        </ul>
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