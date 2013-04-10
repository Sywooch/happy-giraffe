<div class="author-info">
    <?php $this->widget('AvatarWidget', array('user' => $user, 'size' => 'big')); ?>
    <div class="author-info_hold">
        <?=CHtml::link($user->fullName, Yii::app()->createUrl('/community/user', array('user_id' => $user->id)), array('class' => 'author-info_name textdec-onhover'))?>
        <div class="clearfix">
            <div class="author-info_record">
                <div class="author-info_record-t">Записей <br />в клубах</div>
                <span class="btn-lilac btn-medium"><?=$user->communityPostsCount?></span>
            </div>
            <div class="author-info_record">
                <div class="author-info_record-t">Записей <br />в блоге</div>
                <span class="btn-green btn-medium"><?=$user->blogPostsCount?></span>
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