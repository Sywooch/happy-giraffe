<?php
/**
 * @var $model BlogContent
 */
?><div class="like-control like-control__small-indent clearfix">
    <?php $this->widget('UserAvatarWidget', array('user' => $model->author)) ?>
</div>
<div class="like-control clearfix">
    <a href="javascript:;" class="like-control_ico like-control_ico__like<?php if (Yii::app()->user->getModel()->isLiked($model)) echo ' active' ?>"><?=PostRating::likesCount($model) ?></a>
    <a href="javascript:;" class="like-control_ico like-control_ico__repost<?php if (Yii::app()->user->getModel()->isReposted($model)) echo ' active' ?>"><?=$model->sourceCount ?></a>
    <a href="javascript:;" class="like-control_ico like-control_ico__favorites<?php if (Yii::app()->user->getModel()->isAddedToFavourite($model)) echo ' active' ?>"><?=$model->favouritesCount ?></a>
</div>