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
<div class="b-article_t-list"><a href="<?= $data->dataArray['url'] ?>" class="b-article_t-a"><?= $data->dataArray['title'] ?></a></div>
<div class="b-article_in clearfix">
    <div class="wysiwyg-content clearfix">
        <?= $data->dataArray['text'] ?>
    </div>
</div>

