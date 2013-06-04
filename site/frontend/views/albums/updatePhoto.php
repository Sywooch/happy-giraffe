<div id="photoPick" class="popup v2">


    <a href="javascript:;" onclick="$.fancybox.close();" class="popup-close tooltip" title="Закрыть"></a>

    <div class="title">Редактирование фотографии</div>

    <div id="attach_content">
        <div class="form">

            <?php $form = $this->beginWidget('CActiveForm', array(
                'action' => array('/ajax/setValues/'),
                'enableAjaxValidation' => true,
                'clientOptions' => array(
                    'validateOnType' => true,
                ),
                'htmlOptions' => array(
                    'onsubmit' => 'ajaxSetValues(this, function(response) {if (response) {$.fancybox.close(); window.location.reload();}}); return false;',
                ),
            )); ?>
            <?=CHtml::hiddenField('entity', get_class($photo))?>
            <?=CHtml::hiddenField('entity_id', $photo->id)?>

            <div class="photo-upload clearfix">
                <div class="photo">
                    <div class="in">
                        <?=CHtml::image($photo->getPreviewUrl(300, null, Image::WIDTH))?>
                        <!--<a href="" class="remove tooltip" title="Удалить"></a>-->
                    </div>
                </div>

                <div class="photo-title">
                    <label>Название фото <span>(не более 75 знаков)</span></label>
                    <?=$form->textField($photo, 'title')?>
                    <?=$form->error($photo, 'title')?>
                </div>

            </div>

            <div class="form-bottom">
                <button class="btn btn-green-medium"><span><span>Завершить</span></span></button>
            </div>

            <?php $this->endWidget(); ?>

        </div>
    </div>


</div>