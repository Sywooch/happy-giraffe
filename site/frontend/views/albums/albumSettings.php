<div id="albumSettings" class="popup">

    <a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close tooltip" title="Закрыть"></a>

    <div class="popup-title">Настройки фотоальбома</div>

    <!--<div class="default-nav">
        <ul>
            <li class="active"><a href="">Название альбома</a></li>
            <li class="disabled"><a>Настройки 2</a></li>
            <li class="disabled"><a>Настройки 3</a></li>
        </ul>
    </div>-->

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'albumSettings',
        'action' => '/ajax/setValues/',
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'validateOnType' => true,
        ),

        'htmlOptions' => array(
            'onsubmit' => 'ajaxSetValues(this, function() {$.fancybox.close(); window.location.reload();}); return false;',
        ),
    )); ?>
        <?=CHtml::hiddenField('entity', get_class($album))?>
        <?=CHtml::hiddenField('entity_id', $album->id)?>

        <div class="settings-form">

            <div class="row">
                <div class="row-title">Название альбома <span>(не более 30 знаков)</span></div>
                <div class="row-elements">
                    <span class="item-title"><?=$album->title?></span>
                    <a href="javascript:void(0)" onclick="Album.updateField(this)" class="edit tooltip" title="Редактировать название альбома"></a>
                </div>
                <div class="row-elements" style="display: none;">
                    <?=$form->textField($album, 'title', array('placeholder' => 'Введите название альбома'))?>
                    <button onclick="Album.updateFieldSubmit(this, '.item-title'); return false;" class="btn btn-green-small"><span><span>Ok</span></span></button>
                </div>

            </div>
            <div class="row">
                <div class="row-title">Комментарий к альбому</div>
                <div class="row-elements">
                    <p><span><?=$album->description?></span><a href="javascript:void(0)" onclick="Album.updateField(this)" class="edit tooltip" title="Редактировать описание альбома"></a></p>
                </div>
                <div class="row-elements" style="display: none;">
                    <?=$form->textField($album, 'description')?>
                    <button onclick="Album.updateFieldSubmit(this, 'p > span'); return false;" class="btn btn-green-small"><span><span>Ok</span></span></button>
                </div>

            </div>

        </div>

        <div class="bottom">
            <button class="btn btn-green-medium"><span><span>Сохранить настройки</span></span></button>
        </div>

    <?php $this->endWidget(); ?>

</div>