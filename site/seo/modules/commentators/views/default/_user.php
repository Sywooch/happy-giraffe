<?php
/**
 * @var $user User
 * @author Alex Kireev <alexk984@gmail.com>
 */

?><div class="user-info clearfix">
    <a href="http://www.happy-giraffe.ru/user/<?=$user->id ?>/" class="ava small" target="_blank"><?=CHtml::image(isset($user->avatar)?implode('/', array(Yii::app()->params['photos_url'],'thumbs','24x24',$user->id,$user->avatar->fs_name)):'') ?></a>
    <div class="user-info_details">
        <a href="http://www.happy-giraffe.ru/user/<?=$user->id ?>/" class="user-info_username" target="_blank"><?=$user->fullName ?></a>
    </div>
</div>