<div class="b-main_cont">
    <div class="heading-link-xxl"> Мы здесь общаемся!</div>
    <!--Добавить в layout_base-->
    <?php $this->widget('site\frontend\modules\posts\modules\forums\widgets\usersTop\UsersTopWidget'); ?>
    <?php $this->widget('site\frontend\modules\posts\modules\forums\widgets\lastPost\LastPostWidget'); ?>
    <div class="clearfix"></div>
    <?php //$this->widget('site\frontend\modules\posts\modules\forums\widgets\clubs\ClubsWidget'); ?>
    <?php //$this->widget('site\frontend\modules\posts\modules\forums\widgets\onlineUsers\OnlineUsersWidget'); ?>
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