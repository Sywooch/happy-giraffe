<?php
/* @var $this NewCommentWidget
 * @var $data Comment
 */
$count = HGLike::model()->countByEntity($data);
?><a href="javascript:;" class="comments-gray_like like-hg-small<?php
if (HGLike::model()->hasLike($data, Yii::app()->user->id)) echo ' active';
if ($count == 0) echo ' hide';
if (Yii::app()->user->id == $data->author_id) echo ' disable';

?>" onclick="Comments.like(this, <?=$data->id ?>);"><?=$count ?></a>