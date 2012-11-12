<div id="contest"></div>

<div id="takeapartPhotoContest">
    <div class="content-title">Я хочу участвовать в фотоконкурсе</div>

    <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'attach-form',
            'enableClientValidation' => false,
            'enableAjaxValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        )
    ); ?>
        <div class="form">
            <?php echo $form->hiddenField($model, 'file', array('value' => '')); ?>
            <div class="a-right upload-file">
                <?php
                $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
                    'model' => $this->contest,
                ));
                    $fileAttach->button();
                $this->endWidget();
                ?>
                <?php echo $form->error($model, 'file'); ?>
            </div>

            <div class="row">
                <div class="row-title">Название фото</div>
                <div class="row-elements"><?php echo $form->textField($model, 'title', array('maxlength' => 50)); ?></div>
                <?php echo $form->error($model, 'title'); ?>
            </div>

            <div class="clear"></div>

            <div style="text-align:left;" class="form-bottom">
                <label><input type="checkbox" onchange="$('#finish_button').toggleClass('disabled').toggleDisabled();"> Я согласен с</label> <?php echo CHtml::link('Правилами конкурса', array('/contest/default/rules', 'id' => $this->contest->primaryKey)); ?>
                <button class="btn btn-green-medium disabled" id="finish_button" disabled="disabled"><span><span>Участвовать<i class="arr-r"></i></span></span></button>
            </div>

        </div>
    <?php $this->endWidget(); ?>
</div>