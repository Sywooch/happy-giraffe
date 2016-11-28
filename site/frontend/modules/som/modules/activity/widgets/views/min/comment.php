<?php

use site\frontend\modules\som\modules\activity\widgets\ActivityWidget;

$user = $this->getUserInfo($data->userId);
$contentAuthor = $this->getUserInfo($data->dataArray['content']['authorId']);
?>
<div class="b-article_in clearfix">
    <div class="comments comments__buble comments__anonce">
        <div class="comments_hold">
            <div class="comments_li comments_li__lilac">
                <div class="comments_i clearfix">
                    <div class="comments_frame float-n">
                        <div onclick="location.href='<?=$data->dataArray['url']?>'" class="comments_link">
                            <div class="comments_cont">
                                <div class="wysiwyg-content">
                                    <?= $data->dataArray['text'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="<?= $data->dataArray['content']['url'] ?>" class="onair-min_post-header"><?= $data->dataArray['content']['title'] ?></a>
</div>