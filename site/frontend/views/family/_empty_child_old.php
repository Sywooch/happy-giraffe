<input type="hidden" value="" class="baby-id">
<div class="data clearfix">
    <div class="d-text">Имя <?=$i ?>-го ребенка:</div>

    <div class="name">
        <div class="text" style="display:none;"></div>
        <div class="input">
            <input type="text">
            <button class="btn btn-green-small" onclick="Family.saveBabyName(this);"><span><span>Ok</span></span></button>
        </div>
        <a href="javascript:void(0);" onclick="Family.editBabyName(this)" class="edit tooltip" style="display:none;" title="Редактировать имя"></a>
    </div>

    <div style="display:none;" class="hide-on-start">
        <a href="javascript:void(0);" onclick="Family.saveBabyGender(this, 1)" class="gender male tooltip" title="Мальчик"></a>
        <a href="javascript:void(0);" onclick="Family.saveBabyGender(this, 0)" class="gender female tooltip" title="Девочка"></a>

        <div style="display:none;" class="hide-on-start">
            <div class="age">

            </div>
            <div class="date">
                <a href="javascript:void(0);" onclick="Family.editDate(this);" class="date tooltip" title="Укажите дату рождения"></a>
                <div class="datepicker" style="display:none;">
                    <div class="tale"></div>
                    <?php echo CHtml::dropDownList('Baby_d_'.$i, '', array(''=>' ')+HDate::Days(), array(
                    'class'=>'chzn w-50 date',
                    'data-placeholder'=>' '
                )) ?>
                    &nbsp;
                    <?php echo CHtml::dropDownList('Baby_m_'.$i, '', array(''=>' ')+HDate::ruMonths(), array(
                    'class'=>'chzn w-100 month',
                    'data-placeholder'=>' '
                )) ?>
                    &nbsp;
                    <?php echo CHtml::dropDownList('Baby_y_'.$i, '', array(''=>' ')+HDate::Range(date('Y'), date('Y') - 60), array(
                    'class'=>'chzn w-100 year',
                    'data-placeholder'=>' '
                )) ?>
                    &nbsp;
                    <button class="btn btn-green-small" onclick="Family.saveBabyDate(this)"><span><span>Ok</span></span></button>
                </div>
            </div>

            <a href="javascript:void(0);" onclick="Family.editBabyNotice(this)" class="comment tooltip"  title="Расскажите о нем"></a>
            <a href="javascript:void(0);" class="photo tooltip" title="Добавить 4 фото"></span>
                <?php $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'baby_photo_upload2'.$i,
                    'action' => $this->createUrl('uploadBabyPhoto'),
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                        'class'=>'baby_photo_upload',
                    ),
                )); ?>
                <?php echo CHtml::hiddenField('baby_id', '', array('id'=>'baby_id'.$i, 'class'=>'baby_id_2')); ?>
                <?php echo CHtml::fileField('baby-photo', '', array('id'=>'baby-photo'.$i, 'class'=>'baby-photo-file')); ?>
                <?php $this->endWidget(); ?>
            </a>
        </div>

    </div>
</div>

<div class="comment" style="display:none;">
    <div class="input">
        <div class="tale"></div>
        <textarea></textarea>
        <button class="btn btn-green-small" onclick="Family.saveBabyNotice(this)"><span><span>Ok</span></span></button>
    </div>
    <div class="text"><span class="text"></span> <a href="javascript:void(0);" onclick="Family.editBabyNotice(this)" class="edit tooltip" title="Редактировать комментарий"></a></div>
</div>

<div class="photos" style="display:none;">
    <ul>
        <li class="add">
            <a href="javascript:void(0);" class="fake_file">

                <i class="icon"></i>
                <span>Загрузить еще<br> <ins>4</ins> <span>фотографии</span></span>
                <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'baby_photo_upload1'.$i,
                'action' => $this->createUrl('uploadBabyPhoto'),
                'htmlOptions' => array(
                    'enctype' => 'multipart/form-data',
                    'class'=>'baby_photo_upload',
                ),
            )); ?>
                <?php echo CHtml::hiddenField('baby_id', '', array('id'=>'baby_id'.$i, 'class'=>'baby_id_2')); ?>
                <?php echo CHtml::fileField('baby-photo', '', array('id'=>'baby-photo'.$i, 'class'=>'baby-photo-file')); ?>
                <?php $this->endWidget(); ?>
            </a>

        </li>
    </ul>
</div>