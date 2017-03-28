<?php
/**
 * @var site\frontend\modules\userProfile\widgets\UserSectionWidget $this
 * @var \User $user
 */
$cs = Yii::app()->clientScript;
$cs->registerAMD('userSection', array('kow', 'extensions/avatarUpload'));
?>

<section class="userSection<?php if ($this->adaptive): ?> visible-md visible-lg<?php endif; ?> userSection-iframe">
    <div class="userSection_hold">
        <div class="userSection_left userSection-iframe_left">
            <div class="b-ava-large b-ava-large__nohover">
                <?php if ($user->online): ?>
                    <span class="b-ava-large_online">На сайте</span>
                <?php endif; ?>
                <div class="b-ava-large_ava-hold">
                    <?php $this->widget('Avatar', array(
                        'user' => $user,
                        'size' => Avatar::SIZE_LARGE,
                        'largeAdvanced' => false,
                        'htmlOptions' => array(
                            'class' => 'ava__base-xs',
                        ),
                    )); ?>
                </div>
            </div>
        </div>
        <div class="userSection_left">
            <h2 class="userSection_name userSection-iframe_name"><?=$user->getFullName()?></h2>
            <?php $this->widget('site\frontend\modules\iframe\widgets\answers\AnswerHeaderWidget', [
                'userId' => $user->id,
                'view' => 'stat-profile',
            ]);?>
        </div>
        <div class="userSection_right">
            <?php if (empty($user->specInfo)): ?>
                <family-section params="userId: <?= $user->id ?>"></family-section>
                <?php if (false): ?>
                    <?php $this->widget('iframe.modules.userProfile.widgets.FamilyWidget', array('user' => $user)); ?>
                <?php endif; ?>
            <?php else: ?>
                <div class="userSection__pos"><?=$user->specInfoObject->title?></div>
                <div class="userSection__desc">
                    <?=$user->specInfoObject->education?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>