<?php if($this->beginCache('UsersRatingWidget', array('duration' => 300))) {
    $this->widget('site\frontend\modules\som\modules\qa\widgets\usersRating\UsersRatingWidget');
    $this->endCache();
}