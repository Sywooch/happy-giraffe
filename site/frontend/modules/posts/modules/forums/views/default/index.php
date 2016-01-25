<div class="b-main_cont">
    <div class="heading-link-xxl"> Мы здесь общаемся!</div>
    <!--Добавить в layout_base-->

    <?php if($this->beginCache('Forums.UsersTopWidget', array('duration'=>3600))) {$this->widget('site\frontend\modules\posts\modules\forums\widgets\usersTop\UsersTopWidget'); $this->endCache();} ?>
    <?php if($this->beginCache('Forums.LastPostWidget', array('duration'=>3600))) {$this->widget('site\frontend\modules\posts\modules\forums\widgets\lastPost\LastPostWidget'); $this->endCache();} ?>
    <div class="clearfix"></div>
    <?php if($this->beginCache('Forums.ClubsWidget', array('duration'=>3600))) {$this->widget('site\frontend\modules\posts\modules\forums\widgets\clubs\ClubsWidget'); $this->endCache();} ?>
    <?php if($this->beginCache('Forums.OnlineUsersWidget', array('duration'=>3600))) {$this->widget('site\frontend\modules\posts\modules\forums\widgets\onlineUsers\OnlineUsersWidget'); $this->endCache();} ?>
</div>






<?php
if (false) {
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