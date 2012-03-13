<div id="gallery">
    <div class="header">
        <div class="clearfix">
            <div class="user">
                <?php $this->widget('AvatarWidget', array('user' => $user)); ?>
                <p><span><?php echo $user->fullName; ?></span>
                    <?php if($user->country): ?>
                        <br><?php echo $user->country->name; ?></p>
                    <?php endif; ?>
            </div>
            <div class="back-link">&larr; <?php echo CHtml::link('В анкету', array('/user/profile', 'user_id' => $user->id)) ?></div>
        </div>
        <?php if(!Yii::app()->user->isGuest && Yii::app()->user->id == $user->id): ?>
            <div class="all-link">
                <?php echo CHtml::link('<span><span><i class="add"></i>Добавить альбом</span></span>', array('albums/create'), array('class' => 'btn btn-green-medium')); ?>
            </div>
        <?php endif; ?>
        <div class="title">
            <big><span>Фотоальбомы</span></big>
        </div>
    </div>
    <?php foreach ($dataProvider->getData() as $model): ?>
    <div class="fast-album">
        <div class="header">
            <div class="title">
                <big>
                    Альбом <span>&laquo;<?php echo CHtml::link($model->title, array('albums/view', 'id' => $model->id)); ?>&raquo;</span>
                    <?php if($model->checkAccess === true): ?>
                        <?php echo CHtml::link('', array('albums/create', 'id' => $model->id), array('class' => 'edit')); ?>
                    <?php endif; ?>
                </big>
                <?php if ($model->description): ?>
                <div class="note">
                    <?php if($model->checkAccess === true): ?>
                    <div class="fast-actions">
                        <?php echo CHtml::link('', array('/albums/editDescription', 'id' => $model->id), array('class' => 'edit', 'onclick' => 'return Album.editDescription(this);')); ?>
                        <?php echo CHtml::link('', array('/albums/editDescription', 'id' => $model->id), array('class' => 'remove', 'onclick' => 'return Album.removeDescription(this);')); ?>
                    </div>
                    <?php endif; ?>
                    <p><?php echo $model->description; ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="gallery-photos clearfix">
            <ul>
                <?php foreach ($model->getRelated('photos', true, array('limit' => 3)) as $photo): ?>
                    <?php $this->renderPartial('_photo', array('data' => $photo)); ?>
                <?php endforeach; ?>
                <?php if (($count = count($model->photos)) > 3): ?>
                <li class="more">
                    <?php echo CHtml::link('', array('albums/view', 'id' => $model->id), array('class' => 'icon')); ?>
                    еще <?php echo $count - 3; ?> фото
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <?php endforeach; ?>
</div>