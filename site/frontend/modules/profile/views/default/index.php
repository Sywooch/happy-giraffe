<?php
/**
 * @var User $user
 */
Yii::app()->clientScript->registerPackage('ko_profile');

?>
<div class="section-lilac">
    <div class="section-lilac_hold">
        <div class="section-lilac_left">
            <h1 class="section-lilac_name"><?= $user->getFullName() ?></h1>

            <div class="margin-b5 clearfix">
                <?php if ($user->birthday): ?>
                    <?= $user->getNormalizedAge() ?>, <?= $user->birthdayString ?>
                <?php endif ?>
            </div>
            <div class="location clearfix">
                <?php
                if (!empty($user->address->country_id))
                    echo $user->address->getFlag(true, 'span');
                if (!empty($user->address->city_id) || !empty($user->address->region_id))
                    echo '<span class="location-tx">' . $user->address->getUserFriendlyLocation() . '</span>';
                ?>
            </div>
            <div class="user-btns clearfix">
                <?php if ($user->id != Yii::app()->user->id):?>
                    <?php $this->widget('application.widgets.friendButtonWidget.FriendButtonWidget', array('user' => $user, 'view' => 'profile')); ?>

                    <a href="<?=Yii::app()->user->isGuest ? '#login' : $this->createUrl('/messaging/default/index', array('interlocutorId' => $user->id)) ?>" class="user-btns_i powertip<?php if (Yii::app()->user->isGuest): ?> fancy<?php endif; ?>">
                        		<span class="user-btns_ico-hold user-btns_ico-hold__dialog">
                        			<span class="user-btns_ico"></span>
                        		</span>
                        <span class="user-btns_tx"></span>
                    </a>

                    <div class="user-btns_separator"></div>
                <?php endif ?>

                <?php if ($user->hasBlogPosts() || $user->id == Yii::app()->user->id): ?>
                <a href="<?=$user->getBlogUrl() ?>"
                   class="user-btns_i powertip">
                    		<span class="user-btns_ico-hold user-btns_ico-hold__blog">
                    			<span class="user-btns_ico"></span>
                    		</span>
                    <span class="user-btns_tx"><?= $user->blogPostsCount . ' <br> ' . Str::GenerateNoun(array('запись', 'записи', 'записей'), $user->blogPostsCount) ?></span>
                </a>
                <?php endif ?>
                <a href="<?=$user->getPhotosUrl()?>" class="user-btns_i powertip">
                    <span class="user-btns_ico-hold user-btns_ico-hold__photo">
                        <span class="user-btns_ico"></span>
                    </span>
                    <span class="user-btns_tx"><?= $user->getPhotosCount() ?> <br> фото</span>
                </a>
            </div>
        </div>
        <div class="section-lilac_center">
            <?php $this->renderPartial('_ava', array('user' => $user)); ?>
            <div class="section-lilac_center-reg">с Веселым Жирафом <?= $user->withUs() ?></div>
        </div>
        <div class="section-lilac_right">
            <?php $this->widget('FamilyWidget', array('user' => $user)); ?>
        </div>
    </div>
</div>
<div class="content-cols clearfix">
    <div class="col-1">

        <?php $this->widget('UserFriendsWidget', array('user' => $user)); ?>
        <?php $this->widget('AwardsWidget', array('user' => $user)); ?>
        <?php $this->widget('ClubsWidget', array('user' => $user)); ?>

    </div>
    <div class="col-23-middle">

        <?php $this->widget('StatusWidget', array('user' => $user)); ?>

        <?php $this->widget('AboutWidget', array('user' => $user)); ?>

        <?php $this->widget('InterestsWidget', array('user' => $user)); ?>

        <?php if ($user->getPhotosCount() > 3):?>
            <div class="photo-preview-row clearfix">
                <h3 class="heading-small margin-b10">Мои фото</h3>
                <?php $this->widget('UserPhotosWidget', array('userId' => $user->id)); ?>
            </div>
        <?php endif ?>

        <?php $this->widget('CommunityContestWidget', compact('user')); ?>
        <?php $this->widget('PhotoContestWidget', compact('user')); ?>

        <div class="col-23-middle">

        </div>

        <!-- Статьи -->
        <?php if ($user->id == Yii::app()->user->id || $dataProvider->totalItemCount > 0):?>
            <div class="col-gray">

                <?php $this->renderPartial('_subscription', array('user' => $user)); ?>

                <?php $this->renderPartial('_activity', array('user' => $user, 'dataProvider' => $dataProvider)); ?>

            </div>
        <?php endif ?>
    </div>
</div>
