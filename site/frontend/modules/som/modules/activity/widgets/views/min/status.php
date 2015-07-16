<?php

use site\frontend\modules\som\modules\activity\widgets\ActivityWidget;

$user = $this->getUserInfo($data->userId);
?>
<!-- /блок активность пользователя внутри статьи-->
<div class="b-article_in clearfix">
    <div class="user-status user-status__base">
        <div class="user-status_hold">
            <a class="user-status_tx" href="<?= $data->dataArray['url'] ?>"><?= $data->dataArray['text'] ?></a>
        </div>
    </div>
</div>
