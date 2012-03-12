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
            <big>Альбом <input type="text" placeholder="Название альбома"/><button class="btn btn-green-small"><span><span>Ок</span></span></button></big>
            <div class="note">
                <textarea placeholder="Введите комментарий к альбому не более 140 символов"></textarea>
                <button class="btn btn-green-small"><span><span>Ок</span></span></button>
            </div>
        </div>

        <div class="actions">
            <button class="btn btn-green-medium"><span><span>Добавить фото</span></span></button>
            <button class="btn btn-gray-medium"><span><span>Удалить альбом</span></span></button>
        </div>
    </div>
</div>


<div class="form">
<h2><?php echo $model->isNewRecord ? 'Создание' : 'Изменение' ?> альбома</h2>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'album-form',
    'enableAjaxValidation'=>false,
)); ?>
    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title', array('maxlength' => 100)); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textField($model,'description', array('maxlength' => 255)); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
    </div>

<?php $this->endWidget(); ?>