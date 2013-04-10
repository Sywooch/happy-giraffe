<div class="author-info">
    <?php $this->widget('AvatarWidget', array('user' => $user, 'size' => 'big')); ?>
    <div class="author-info_hold">
        <?=CHtml::link($user->fullName, Yii::app()->createUrl('/community/user', array('user_id' => $user->id)), array('class' => 'author-info_name textdec-onhover'))?>
        <div class="clearfix">
            <div class="author-info_record">
                <div class="author-info_record-t">Записей <br />в клубах</div>
                <a href="" class="btn-lilac btn-medium"><?=$user->communityPostsCount?></a>
            </div>
            <div class="author-info_record">
                <div class="author-info_record-t">Записей <br />в блоге</div>
                <a href="" class="btn-green btn-medium"><?=$user->blogPostsCount?></a>
            </div>
        </div>
    </div>
</div>

<?php $this->widget('MListView', array(
    'dataProvider' => $dp,
    'itemView' => '_post',
    'viewData' => array(
        'full' => false,
    ),
    'pager' => array(
        'class' => 'MPager',
    ),
)); ?>