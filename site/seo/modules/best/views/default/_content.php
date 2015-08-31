<?php
$adapter = new \site\frontend\modules\posts\components\MailAdapter($article);
$comments = $adapter->getComments();
?>

<li class="best-list_li b-best_i" id="<?= $model->_id ?>">

    <div class="user-info clearfix">
        <a href="" class="ava"><img src="<?= SeoUser::getAvatarUrlForUser($adapter->getUser(), 72) ?>"/></a>
        <div class="user-info_details">
            <a href="" class="user-info_username"><?= $adapter->getUser()->first_name ?></a>
        </div>
    </div>

    <div class="best-list_date"><?=  Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $article->dtimeCreate); ?></div>

    <b class="best-list_t"><a href=""><?= $article->title ?></a></b>

    <div class="best-list_tx">
        <?php $photo = $adapter->getPhoto(); ?>
        <?php if ($photo): ?>
            <img src="<?=$photo?>" alt="" width="318"/>
        <?php endif ?>
        <p><?= $adapter->getText(); ?>
            <a href="" class="best-list_more">Читать всю запись</a>
        </p>
    </div>

    <div class="best-list_row clearfix">
        <span class="best-list_views"><?= PageView::model()->viewsByPath(ltrim($article->url, '.'), true); ?></span>
        <a href="" class="best-list_comments"><?= $comments->getCount() ?></a>
        <?php $used = array(); ?>
        <?php $j = 0; foreach ($comments->dataProvider->data as $comment): ?>
            <?php if (!empty($comment->author->avatar_id) && !in_array($comment->author->avatar_id, $used)):?>
                <?php $j++;$used[] = $comment->author->avatar_id ?>
                <a href="" class="ava small"><img src="<?= SeoUser::getAvatarUrlForUser($comment->author, 24) ?>"></a>
                <?php if ($j == 5) break; ?>
            <?php endif ?>
        <?php endforeach; ?>
    </div>

    <div class="b-best_overlay">
        <div class="b-best_overlay-tx">
            Вы можете переместить или удалить. <br>
            <a href="http://www.happy-giraffe.ru<?= $article->url ?>" target="_blank">Перейти
                на пост</a>
        </div>
    </div>
    <a href="javascript:;" class="b-best_close"
       onclick="EditFavourites.remove('<?= $model->_id ?>', this);"></a>
    <a href="" class="b-best_drag"></a>
</li>