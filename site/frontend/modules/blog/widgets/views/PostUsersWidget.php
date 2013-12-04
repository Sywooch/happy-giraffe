<?php
/**
 * @var User[] $likedUsers
 * @var User[] $favouritedUsers
 * @var bool $hasLike
 * @var bool $hasFavourite
 * @var int $likesCount
 * @var int $favouritedCount
 */
?>

<div class="article-users">
    <?php if ($likedUsers): ?>
        <div class="article-users_t"><?=$label?> понравилась </div>
        <div class="ava-list">
            <ul class="ava-list_ul clearfix">
                <?php foreach ($likedUsers as $user): ?>
                    <li class="ava-list_li">
                        <?php $this->widget('Avatar', array('user' => $user, 'size' => 24)) ?>
                    </li>
                <?php endforeach; ?>

                <?php if ($this->post->author_id != Yii::app()->user->id): ?>
                    <li class="ava-list_li">
                        <?php if (Yii::app()->user->isGuest): ?>
                            <a href="#login" class="ava-list_last powertip fancy" title="Нравится">
                                <span class="ava-list_like-hg"></span>
                                <span class="count"><?=$likesCount?></span>
                            </a>
                        <?php else: ?>
                            <a href="javascript:void(0)" class="ava-list_last" onclick="HgLikeSmall(this, '<?=$class?>',<?=$this->post->id?>)">
                                <span class="ava-list_like-hg<?php if ($hasLike):?> active<?php endif; ?>"></span>
                                <span class="count"><?=$likesCount?></span><span class="andyou"<?php if (! $hasLike):?> style="display:none;"<?php endif; ?>> и вы</span>
                            </a>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($favouritedUsers): ?>
        <div class="article-users_t"><?=$label?> добавили в избранное </div>
        <div class="ava-list">
            <ul class="ava-list_ul clearfix">
                <?php foreach ($favouritedUsers as $user): ?>
                    <li class="ava-list_li">
                        <?php $this->widget('Avatar', array('user' => $user, 'size' => 24)) ?>
                    </li>
                <?php endforeach; ?>

                <?php if ($this->post->author_id != Yii::app()->user->id): ?>
                    <li class="ava-list_li">
                        <?php $this->widget('FavouriteWidget', array('model' => $this->post, 'right' => true, 'small' => true)); ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>