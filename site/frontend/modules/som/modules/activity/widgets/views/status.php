<?php

use site\frontend\modules\som\modules\activity\widgets\ActivityWidget;

$user = $this->getUserInfo($data->userId);
?>
<div class="user-activity-post">
    <div class="user-activity-post_hold clearfix">
        <span class="ico-post-type-s ico-post-type-s__<?= ActivityWidget::$types[$data->typeId][0] ?>"></span>
        <span class="user-activity-post_tx"> <?= ActivityWidget::$types[$data->typeId][2][$user->gender] ?></span>
    </div>
</div>
<!-- /блок активность пользователя внутри статьи-->
<div class="b-article_in clearfix">
    <div class="user-status user-status__base">
        <div class="user-status_hold">
            <a class="user-status_tx" href="<?= $data->dataArray['url'] ?>"><?= $data->dataArray['text'] ?></a>
        </div>
    </div>
</div>
