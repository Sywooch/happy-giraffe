<?php
/**
 * @var LiteController $this
 * @var site\frontend\modules\family\models\Family $family
 * @var integer $userId
 */
$this->metaNoindex = true;
$this->breadcrumbs = array(
    'Семья',
);
$this->adaptiveBreadcrumbs = true;
if ($this->owner->id == Yii::app()->user->id) {
    $this->pageTitle = 'Моя семья';
} else {
    $this->pageTitle = 'Семья - ' . $this->owner->fullName;
}
?>

<?php $this->widget('site\frontend\modules\userProfile\widgets\UserSectionWidget', array('user' => $this->owner)); ?>

<div class="b-main_cont b-main_cont__wide">
    <div class="family-user">
        <div class="textalign-c">
            <div class="ico-myfamily ico-myfamily__l"></div>
        </div>
        
        <?php if ($this->owner->id == Yii::app()->user->id): ?>
            <div class="family-user_edit-hold"> 
                <a href='<?=$this->createUrl('/family/default/fill', array('userId' => $userId))?>' class="btn btn-secondary btn-l"><div class="ico-edit ico-edit__s"></div>&nbsp;Редактировать</a>
            </div>
        <?php endif; ?>

        <?php $this->renderPartial('_mainPhoto', compact('family')); ?>
        <!-- family-about-->
        <div class="family-about">
            <?php if ($family->description): ?>
                <div class="family-about_bubble">
                    <div class="family-about_t">О нашей семье</div>
                    <div class="family-about_tx"><?= htmlentities($family->description, ENT_COMPAT, 'utf-8') ?></div>
                </div>
            <?php endif; ?>
            <?php $this->widget('site\frontend\modules\family\widgets\MembersListWidget\MembersListWidget', array(
                'family' => $family,
                'view' => 'short',
                'me' => $userId,
            )); ?>
        </div>
        <!-- /family-about-->
        <div class="visible-md">
            <!-- family-member-->
            <?php $this->widget('site\frontend\modules\family\widgets\MembersListWidget\MembersListWidget', array(
                'family' => $family,
                'view' => 'full',
                'me' => $userId,
            )); ?>
            <!-- /family-member-->
            <!-- <div class="i-allphoto"> <a href="" class="i-allphoto_a">Смотреть семейный альбом</a></div> -->
        </div>
    </div>
</div>