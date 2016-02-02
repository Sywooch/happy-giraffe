<?php if (! Yii::app()->user->isGuest): ?>
    <div class="personal-links">
        <a href="<?=Yii::app()->user->apiModel->profileUrl?>" class="ava ava__middle ava__<?=(Yii::app()->user->apiModel->gender) ? 'male' : 'female'?>">
            <?php if (Yii::app()->user->apiModel->avatarUrl): ?>
                <img alt="" src="<?=Yii::app()->user->apiModel->avatarUrl?>" class="ava_img">
            <?php endif; ?>
        </a>
        <?php $this->widget('site\frontend\modules\som\modules\qa\widgets\my\SidebarPersonalWidget', array(
            'userId' => Yii::app()->user->id,
        )); ?>
    </div>
<?php endif; ?>