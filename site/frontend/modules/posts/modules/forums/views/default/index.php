<?php
Yii::beginProfile('lastPost');
$this->widget('site\frontend\modules\posts\modules\forums\widgets\lastPost\LastPostWidget');
Yii::endProfile('lastPost');

Yii::beginProfile('usersTop');
$this->widget('site\frontend\modules\posts\modules\forums\widgets\usersTop\UsersTopWidget');
Yii::endProfile('usersTop');

Yii::beginProfile('clubs');
$this->widget('site\frontend\modules\posts\modules\forums\widgets\clubs\ClubsWidget');
Yii::endProfile('clubs');