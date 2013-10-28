<?php
/**
 * @var CommunityContent $data
 */

$likedUsers = $data->getLikedUsers(33);
$favouritedUsers = $data->getFavouritedUsers(33);
$hasLike = ! Yii::app()->user->isGuest && HGLike::model()->hasLike($data, Yii::app()->user->id);
$hasFavourite = ! Yii::app()->user->isGuest && Favourite::model()->getUserHas(Yii::app()->user->id, $data);
$likesCount = HGLike::model()->countByEntity($data) - ($hasLike ? 1 : 0);
$favouritedCount = Favourite::model()->getCountByModel($data) - ($hasFavourite ? 1 : 0);
?>

<div class="article-users">
    <?php if ($likedUsers): ?>
        <div class="article-users_t">Запись понравилась </div>
        <div class="ava-list">
            <ul class="ava-list_ul clearfix">
                <?php foreach ($likedUsers as $user): ?>
                    <li class="ava-list_li">
                        <?php $this->widget('Avatar', array('user' => $user, 'size' => 24)) ?>
                    </li>
                <?php endforeach; ?>

                <li class="ava-list_li">
                    <a href="javascript:void(0)" class="ava-list_last">
                        <span class="ava-list_like-hg<?php if ($hasLike):?> active<?php endif; ?>"></span>
                        <?=$likesCount?><?php if ($hasLike):?> и вы<?php endif; ?>
                    </a>
                </li>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($favouritedUsers): ?>
        <div class="article-users_t">Запись добавили в избранное </div>
        <div class="ava-list">
            <ul class="ava-list_ul clearfix">
                <?php foreach ($favouritedUsers as $user): ?>
                    <li class="ava-list_li">
                        <?php $this->widget('Avatar', array('user' => $user, 'size' => 24)) ?>
                    </li>
                <?php endforeach; ?>

                <li class="ava-list_li">
                    <a href="javascript:void(0)" class="ava-list_last">
                        <span class="ava-list_favorite<?php if ($hasFavourite):?> active<?php endif; ?>"></span>
                        <?=$favouritedCount?><?php if ($hasFavourite):?> и вы<?php endif; ?>
                    </a>
                </li>
            </ul>
        </div>
    <?php endif; ?>
</div>