<div class="b-main_cont">
    <div class="heading-link-xxl"> Мы здесь общаемся!</div>
    <!--Добавить в layout_base-->

    <?php Yii::beginProfile('sersTop'); $this->widget('site\frontend\modules\posts\modules\forums\widgets\usersTop\UsersTopWidget');Yii::endProfile('sersTop'); ?>
    <?php Yii::beginProfile('lastPost'); $this->widget('site\frontend\modules\posts\modules\forums\widgets\lastPost\LastPostWidget');Yii::endProfile('lastPost'); ?>
    <div class="clearfix"></div>
    <?php //Yii::beginProfile('clubs'); $this->widget('site\frontend\modules\posts\modules\forums\widgets\clubs\ClubsWidget'); Yii::endProfile('clubs'); ?>
    <?php Yii::beginProfile('onlineUsers'); $this->widget('site\frontend\modules\posts\modules\forums\widgets\onlineUsers\OnlineUsersWidget'); Yii::endProfile('onlineUsers'); ?>
</div>






<?php
if (false) { ?>
<?php if($this->beginCache('Forums.UsersTopWidget', array('duration'=>3600))) {$this->widget('site\frontend\modules\posts\modules\forums\widgets\usersTop\UsersTopWidget'); $this->endCache();} ?>
<?php if($this->beginCache('Forums.LastPostWidget', array('duration'=>3600))) {$this->widget('site\frontend\modules\posts\modules\forums\widgets\lastPost\LastPostWidget'); $this->endCache();} ?>
<div class="clearfix"></div>
<?php if($this->beginCache('Forums.ClubsWidget', array('duration'=>3600))) {$this->widget('site\frontend\modules\posts\modules\forums\widgets\clubs\ClubsWidget'); $this->endCache();} ?>
<?php if($this->beginCache('Forums.OnlineUsersWidget', array('duration'=>3600))) {$this->widget('site\frontend\modules\posts\modules\forums\widgets\onlineUsers\OnlineUsersWidget'); $this->endCache();} ?>
<?
    Yii::beginProfile('lastPost');
    $this->widget('site\frontend\modules\posts\modules\forums\widgets\lastPost\LastPostWidget');
    Yii::endProfile('lastPost');

    Yii::beginProfile('usersTop');
    $this->widget('site\frontend\modules\posts\modules\forums\widgets\usersTop\UsersTopWidget');
    Yii::endProfile('usersTop');

    Yii::beginProfile('clubs');
    $this->widget('site\frontend\modules\posts\modules\forums\widgets\clubs\ClubsWidget');
    Yii::endProfile('clubs');

    Yii::beginProfile('onlineUsers');
    $this->widget('site\frontend\modules\posts\modules\forums\widgets\onlineUsers\OnlineUsersWidget');
    Yii::endProfile('onlineUsers');
}