<?php
/**
 * @var $this BlogController
 * @var $data BlogContent
 */
?>
<?=$this->user->avatar->id ?><br>
<?=$this->user->getFullName() ?><br>
<?=PageView::model()->viewsByPath($data->getUrl()) ?><br>
<?=$data->commentsCount ?><br>
<?=$data->sourceCount ?><br>
<?=$data->favouritesCount ?><br>
<?=PostRating::likesCount($data) ?><br>
<br><br><br>