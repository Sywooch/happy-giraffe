<p><?php echo CHtml::link('Создать альбом', array('albums/create')); ?></p>
<div id="gallery">
    <div class="header">
        <div class="clearfix">
            <div class="user">
                <?php $this->widget('AvatarWidget', array('user' => $user, 'withMail' => false)); ?>
                <p><span><?php echo $user->fullName; ?></span>
                    <?php if($user->country): ?>
                        <br><?php echo $user->country->name; ?></p>
                    <?php endif; ?>
            </div>
            <div class="back-link">← <?php echo CHtml::link('В анкету', array('/user/profile', 'user_id' => $user->id)) ?></div>
        </div>
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
                        <a href="" class="edit"></a>
                    <?php endif; ?>
                </big>
                <?php if ($model->description): ?>
                <div class="note">
                    <?php if($model->checkAccess === true): ?>
                    <div class="fast-actions">
                        <a href="" class="edit"></a>
                        <a href="" class="remove"></a>
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
                <li>
                    <table>
                        <tr>
                            <td class="img">
                                <div>
                                    <?php echo CHtml::link(CHtml::image($photo->getPreviewUrl(180, 180)), array('photo', 'id' => $photo->id)); ?>
                                </div>
                            </td>
                        </tr>
                        <tr class="title">
                            <td align="center">
                                <div><?php echo $photo->file_name ?></div>
                            </td>
                        </tr>
                    </table>
                </li>
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