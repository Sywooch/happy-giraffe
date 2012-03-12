<div id="gallery">
    <div class="header">
        <div class="clearfix">
            <div class="user">
                <?php $this->widget('AvatarWidget', array('user' => $model->user)); ?>
                <p><span><?php echo $model->user->fullName; ?></span>
                    <?php if($model->user->country): ?>
                        <br><?php echo $model->user->country->name; ?></p>
                    <?php endif; ?>
            </div>
            <div class="back-link">&larr; <?php echo CHtml::link('В анкету', array('/user/profile', 'user_id' => $model->user->id)) ?></div>
        </div>
        <div class="title">
            <big>
                Альбом <span>&laquo;<?php echo $model->title; ?>&raquo;</span>
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
        <?php if($model->checkAccess === true): ?>
            <?php
            $file_upload = $this->beginWidget('site.frontend.widgets.fileUpload.FileUploadWidget');
            $file_upload->loadScripts();
            $this->endWidget();
            ?>
            <div class="actions">
                <?php echo CHtml::link('<span><span>Добавить фото</span></span>', array('addPhoto', 'a' => $model->primaryKey), array('class' => 'fancy btn btn-green-medium')); ?>
                <button class="btn btn-gray-medium"><span><span>Удалить альбом</span></span></button>
            </div>
        <?php endif; ?>
    </div>
    <div class="gallery-photos clearfix">
        <ul>
            <?php foreach ($model->photos as $photo): ?>
            <li>
                <table>
                    <tr>
                        <td class="img">
                            <div>
                                <?php echo CHtml::link(CHtml::image($photo->getPreviewUrl(180, 180)), array('/albums/photo', 'id' => $photo->id)); ?>
                                <?php if($photo->checkAccess): ?>
                                    <a href="" class="remove"></a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <tr class="title">
                        <td align="center">
                            <div>
                                <?php echo $photo->file_name ?>
                                <?php if($photo->checkAccess): ?>
                                    <a href="" class="edit"></a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>