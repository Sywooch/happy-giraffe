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
        'action' => array('/ajax/setValues/'),
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnType' => true,
        ),
        'htmlOptions' => array(
            'onsubmit' => 'ajaxSetValues(this, function(response) {if (response) {$.fancybox.close(); window.location.reload();}}); return false;',
        ),
    )); ?>
    <?=CHtml::hiddenField('entity', get_class($album))?>
    <?=CHtml::hiddenField('entity_id', $album->id)?>

    <div class="settings-form">

        <div class="row">
            <div class="row-title">Название альбома <span>(не более 30 знаков)</span></div>
            <div class="row-elements"<?php if (!$album->title): ?> style="display: none;"<?php endif; ?>>
                <span class="item-title"><?=$album->title?></span>
                <a href="javascript:void(0)" onclick="Album.updateField(this)" class="edit tooltip" title="Редактировать название альбома"></a>
            </div>
            <div class="row-elements"<?php if ($album->title): ?> style="display: none;"<?php endif; ?>>
                <?=$form->textField($album, 'title', array('placeholder' => 'Введите название альбома'))?>
                <button onclick="Album.updateFieldSubmit(this, '.item-title'); return false;" class="btn btn-green-small"><span><span>Ok</span></span></button>
            </div>
            <?=$form->error($album, 'title')?>

        </div>
        <div class="row">
            <div class="row-title">Комментарий к альбому</div>
            <div class="row-elements"<?php if (!$album->description): ?> style="display: none;"<?php endif; ?>>
                <p><span><?=$album->description?></span><a href="javascript:void(0)" onclick="Album.updateField(this)" class="edit tooltip" title="Редактировать описание альбома"></a></p>
            </div>
            <div class="row-elements"<?php if ($album->description): ?> style="display: none;"<?php endif; ?>>
                <?=$form->textField($album, 'description')?>
                <button onclick="Album.updateFieldSubmit(this, 'p > span'); return false;" class="btn btn-green-small"><span><span>Ok</span></span></button>
            </div>
            <?=$form->error($album, 'description')?>

        </div>

    </div>

    <div class="bottom">
        <button class="btn btn-green-medium"><span><span>Сохранить настройки</span></span></button>
    </div>

    <?php $this->endWidget(); ?>

</div>