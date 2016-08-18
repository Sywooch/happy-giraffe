<?php
/**
 * @var User $user
 */
$this->pageTitle = $user->getFullName() . ' на Веселом Жирафе';
$this->breadcrumbs[] = $this->widget('Avatar', array(
    'user' => $user,
    'size' => \Avatar::SIZE_MICRO,
    'tag' => 'span',
), true);
$this->adaptiveBreadcrumbs = true;
?>

<section class="userSection">
    <div class="userSection_hold">
        <div class="userSection_left">
            <h2 class="userSection_name"><?=$user->getFullName()?></h2>
            <div class="margin-b5 clearfix"><?=$user->specialistInfoObject->title?></div>
        </div>
        <div class="userSection_center">
            <?php if ($withUs = $user->withUs()): ?>
                <div class="userSection_center-reg">с Веселым Жирафом <?=$withUs?></div>
            <?php endif; ?>
            <div class="b-ava-large b-ava-large__nohover">
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
                <?php if ($user->online): ?>
                    <span class="b-ava-large_online">На сайте</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<div class="b-main_cont b-main_cont__broad">
    <div class="b-main_col-hold clearfix">
        <!--/////     -->
        <!-- Основная колонка-->
        <div class="b-main_col-article">
            <?php $contestWidget = $this->widget('site\frontend\modules\comments\modules\contest\widgets\ProfileWidget', array(
                'userId' => $user->id,
            )); ?>
            <?php
            $this->widget('site\frontend\modules\som\modules\activity\widgets\ActivityWidget', array(
                'setNoindexIfEmpty' => true,
                'setNoindexIfPage' => true,
                'pageVar' => 'page',
                'ownerId' => $user->id,
            ));
            ?>
        </div>
        <!--/////-->
        <!-- Сайд бар  -->
        <aside class="b-main_col-sidebar visible-md">
            <?php $this->widget('site\frontend\modules\userProfile\widgets\PhotoWidget', compact('user')); ?>
            <!-- виджет друзья-->
            <friends-section params="userId: <?= $user->id ?>"></friends-section>
            <!-- /виджет друзья-->
            <!-- виджет клубы-->
            <clubs-section params="userId: <?= $user->id ?>"></clubs-section>
            <!-- /виджет клубы-->

        </aside>
    </div>
</div>