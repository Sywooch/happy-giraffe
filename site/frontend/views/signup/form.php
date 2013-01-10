    <div class="reg2">

        <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'reg-form2',
        'action' => '#',
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'inputContainer' => '.row',
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'validateOnType' => false,
            'validationUrl' => Yii::app()->createUrl('/signup/validate', array('step' => 2)),
            'afterValidate' => "js:function(form, data, hasError) {
                            if (!hasError){
                                Register.finish();
                            }
                            return false;
                          }",
        )));?>

        <div class="register-form">

            <div class="block-title"><?=$this->template[$type]['step2']['title1'] ?></div>

            <div class="hl">
                <span><?=$this->template[$type]['step2']['title2'] ?></span>
            </div>

            <div class="clearfix">

                <div class="ava-box">

                    <div class="ava"<?php if (empty($model->avatar)) echo ' style="display:none;"' ?>>
                        <?php if (!empty($model->photo)) echo CHtml::image($model->photo, 'Это Вы') ?>
                    </div>

                </div>
                <?=CHtml::hiddenField('form_type', $type) ?>
                <?php if (!empty($model->avatar))
                    echo $form->hiddenField($model, 'avatar', array('value' => $model->avatar)); ?>

                <div class="form-in">

                    <div class="row clearfix">
                        <div class="row-title">
                            <label>Имя:</label>
                        </div>
                        <div class="row-elements">
                            <?=$form->textField($model, 'first_name'); ?>
                        </div>
                        <div class="row-error">
                            <i class="error-ok"></i>
                            <?=$form->error($model, 'first_name'); ?>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="row-title">
                            <label>Фамилия:</label>
                        </div>
                        <div class="row-elements">
                            <?=$form->textField($model, 'last_name'); ?>
                        </div>
                        <div class="row-error">
                            <i class="error-ok"></i>
                            <?=$form->error($model, 'last_name'); ?>
                        </div>
                    </div>

                    <div class="row clearfix email2-row"<?php if (!empty($model->email)) echo ' style="display: none;"' ?>>
                        <div class="row-title">
                            <label>E-mail:</label>
                        </div>
                        <div class="row-elements">
                            <?=$form->textField($model, 'email', array('class' => 'regmail2')); ?>
                        </div>
                        <div class="row-error">
                            <i class="error-ok"></i>
                            <?=$form->error($model, 'email'); ?>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="row-title">
                            <label>Пароль:</label>
                        </div>
                        <div class="row-elements">
                            <?=$form->passwordField($model, 'password', array('autocomplete'=>'off')); ?>
                        </div>
                        <div class="row-error">
                            <i class="error-ok"></i>
                            <?=$form->error($model, 'password'); ?>
                        </div>
                    </div>

                    <?php $this->renderPartial('step2_'.$type,compact('model', 'form')) ?>

                    <div class="row clearfix row-center">
                        <input type="submit" value="Регистрация">
                    </div>

                </div>

            </div>

        </div>

        <?php $this->endWidget(); ?>
    </div>

    <div class="register-finish reg3 clearfix" style="display: none;">

        <div class="logo-box">
            <?=HHtml::link('', '/', array('class' => 'logo'), true)?>
        </div>

        <div class="green">Ура, вы с нами!</div>

        <div class="ava"<?php if (empty($model->avatar)) echo ' style="display:none;"' ?>>
            <?php if (!empty($model->photo)) echo CHtml::image($model->photo, 'Это Вы') ?>
        </div>

        <div class="preparing"><?=$this->template[$type]['step3']['title1'] ?><span>
            <span id="reg_timer">3</span> сек.</span></div>

    </div>