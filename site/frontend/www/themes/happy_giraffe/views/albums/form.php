<?php
Yii::app()->clientScript->registerScript('Album.editMode', 'Album.editMode = true');

$file_upload = $this->beginWidget('site.frontend.widgets.fileUpload.FileUploadWidget');
$file_upload->loadScripts();
$this->endWidget();
?>
<div id="gallery">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'album-form',
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
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
                <!--<button class="btn btn-green-small"><span><span>Ок</span></span></button>-->
                <?php echo $form->error($model, 'title'); ?>
            </big>
            <div class="note">
                <?php echo $form->textArea($model, 'description', array('placeholder' => 'Введите комментарий к альбому не более 140 символов')); ?>
                <!--<button class="btn btn-green-small"><span><span>Ок</span></span></button>-->
            </div>
        </div>

        <div class="actions">
            <?php echo CHtml::link('<span><span>Добавить фото</span></span>', array('addPhoto'), array('class' => 'fancy btn btn-green-medium')); ?>
            <?php if($model->isNewRecord === false): ?>
                <button class="btn btn-gray-medium"><span><span>Удалить альбом</span></span></button>
            <?php endif; ?>
        </div>
    </div>

    <div class="gallery-photos clearfix">
        <ul id="photos_list">
            <?php foreach($model->albumPhotos as $i => $photo): ?>
                <?php $this->renderPartial('_photo_author', array('data' => $photo)); ?>
            <?php endforeach; ?>
        </ul>
    </div>
    <br/>
    <center><button class="btn btn-green-medium"><span><span>Сохранить</span></span></button></center>
    <?php $this->endWidget(); ?>
</div>
<script type="text/x-jquery-tmpl" id="new_photo_template">
    <li>
        <table>
            <tbody><tr>
                <td class="img">
                    <div>
                        <img alt="" src="${src}" style="width:180px;" /></a>
                        <a class="remove" href="" onclick="$(this).parents('li:eq(0)').remove();return false;"></a>
                    </div>
                </td>
            </tr>
            <tr class="title editing">
                <td align="center">
                    <div>
                        <input type="hidden" name="Photo[fsn][]" value="${fsn}" />
                        <input type="hidden" value="" name="Photo[id][]" />
                        <input type="text" value="" name="Photo[title][]" />
                        <button onclick="return Album.savePhoto(this);" class="btn btn-green-small"><span><span>Ок</span></span></button>
                    </div>
                    <div style="display:none;">
                        <span></span>
                        <a onclick="return Album.editPhoto(this);" href="" class="edit"></a>
                    </div>
                </td>
            </tr>
        </tbody></table>
    </li>
</script>
<?php
$remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
$remove_tmpl->registerTemplates();
$this->endWidget();
?>