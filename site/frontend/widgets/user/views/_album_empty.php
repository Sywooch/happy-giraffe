<?php
if(count($this->user->albums) == 0)
{
    $link = Yii::app()->createUrl('/albums/create/');
}
else
{
    $album = Album::model()->find(new CDbCriteria(array(
        'condition' => 'author_id = :user_id',
        'order' => 'created desc',
        'params' => array(':user_id' => $this->user->id),
    )));
    $link = Yii::app()->createUrl('/albums/view', array('id' => $album->id));
}
?>
<div class="user-photo-add user-add">
    <a href="<?php echo $link; ?>"><img src="/images/user_photo_add.png"></a>
    <a href="<?php echo $link; ?>">Я хочу<br>загрузить<br>фото!</a>
</div>