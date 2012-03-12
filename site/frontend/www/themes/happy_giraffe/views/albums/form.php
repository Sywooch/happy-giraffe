<div id="gallery">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'album-form',
        'enableAjaxValidation'=>false,
    )); ?>
    <div class="header">
        <div class="clearfix">
            <div class="user">
                <?php $this->widget('AvatarWidget', array('user' => $model->user)); ?>
                <p><span><?php echo $model->user->fullName; ?></span>
                    <?php if($model->user->country): ?>
                        <br><?php echo $model->user->country->name; ?>
                    <?php endif; ?>
                </p>
            </div>
            <div class="back-link">&larr; <?php echo CHtml::link('В анкету', array('/user/profile', 'user_id' => $model->user->id)) ?></div>
        </div>

        <div class="title">
            <big>
                Альбом
                <?php echo $form->textField($model, 'title', array('placeholder' => $model->getAttributeLabel('title'))); ?>
                <button class="btn btn-green-small"><span><span>Ок</span></span></button>
                <?php echo $form->error($model, 'title'); ?>
            </big>
            <div class="note">
                <?php echo $form->textArea($model, 'description', array('placeholder' => 'Введите комментарий к альбому не более 140 символов')); ?>
                <button class="btn btn-green-small"><span><span>Ок</span></span></button>
            </div>
        </div>

        <div class="actions">
            <button class="btn btn-green-medium"><span><span>Добавить фото</span></span></button>
            <?php if($model->isNewRecord === false): ?>
                <button class="btn btn-gray-medium"><span><span>Удалить альбом</span></span></button>
            <?php endif; ?>
        </div>
    </div>

    <div class="gallery-photos clearfix">
        <ul>
            <?php foreach($model->photos as $photo): ?>
                <li>
                    <table>
                        <tr>
                            <td class="img">
                                <div>
                                    <?php echo CHtml::link(CHtml::image($photo->getPreviewUrl(180, 180)), array('/albums/photo', 'id' => $photo->id)); ?>
                                    <a href="" class="remove"></a>
                                </div>
                            </td>
                        </tr>
                        <tr class="title editing">
                            <td align="center">
                                <div>
                                    <input type="text" />
                                    <button class="btn btn-green-small"><span><span>Ок</span></span></button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php $this->endWidget(); ?>
</div>