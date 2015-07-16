<?php

use site\frontend\modules\som\modules\activity\widgets\ActivityWidget;

$user = $this->getUserInfo($data->userId);
?>
<!-- /блок активность пользователя внутри статьи-->
<div class="b-article_t-list"><a href="<?= $data->dataArray['url'] ?>" class="b-article_t-a"><?= $data->dataArray['title'] ?></a></div>
<div class="b-article_in clearfix">
    <div class="wysiwyg-content clearfix">
        <?= $data->dataArray['text'] ?>
    </div>
</div>

