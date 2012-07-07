<?php
/**
 * @var $form CActiveForm
 */
?>
<div style="display:none">
    <div id="register" class="popup">
        <div class="reg1">
            <div class="popup-title">Регистрация</div>
            <?php Yii::app()->eauth->renderWidget(array('action' => 'signup/index')); ?>

            <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'reg-form1',
            'action' => '#',
            'enableClientValidation' => true,
            'enableAjaxValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnChange' => true,
                'validateOnType' => true,
                'validationUrl' => Yii::app()->createUrl('/signup/validate', array('step' => 1)),
                'afterValidate' => "js:function(form, data, hasError) {
                            if (!hasError){
                                Register.step1();
                            }
                            return false;
                          }",
            )));?>
            <div class="form">

                <div class="row">
                    <div class="row-title">Ваш e-mail:</div>
                    <div class="row-elements"><?php echo $form->textField($model, 'email', array('id'=>'regmail1')); ?></div>
                    <p><?php echo $form->error($model, 'email'); ?></p>
                </div>

            </div>
            <input type="submit" value="Рег">
            <?php $this->endWidget(); ?>

        </div>

        <div class="reg2" style="display: none;">

            <div class="popup-title">Регистрация</div>
            <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'reg-form2',
            'action' => '#',
            'enableClientValidation' => true,
            'enableAjaxValidation' => true,
            'clientOptions' => array(
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
            <div class="form">
                <?php if (isset($regdata['birthday'])) echo $form->hiddenField($model, 'birthday', array('value' => $regdata['birthday'])); ?>
                <?php if (isset($regdata['avatar'])) echo $form->hiddenField($model, 'avatar', array('value' => $regdata['avatar'])); ?>

                <?php echo $form->hiddenField($model, 'email', array('id' => 'regmail2')); ?>

                <div class="row clearfix">
                    <div class="row-title">имя:</div>
                    <div class="row-elements">
                        <?php echo $form->textField($model, 'first_name'); ?>
                        <?php echo $form->error($model, 'first_name'); ?>
                    </div>

                </div>

                <div class="row clearfix">
                    <div class="row-title">Фамилия:</div>
                    <div class="row-elements">
                        <?php echo $form->textField($model, 'last_name'); ?>
                        <?php echo $form->error($model, 'last_name'); ?>
                    </div>

                </div>

                <div class="row clearfix">
                    <div class="row-title">Ваш пароль:</div>
                    <div class="row-elements">
                        <?php echo $form->passwordField($model, 'password'); ?>
                        <?php echo $form->error($model, 'password'); ?>
                    </div>

                </div>

                <div class="row clearfix">
                    <div class="row-title">Ваш e-mail:</div>
                    <div class="row-elements">
                        <?php echo $form->radioButtonList($model, 'gender', array(1 => 'man', 0 => 'woman')); ?>
                        <?php echo $form->error($model, 'gender'); ?>
                    </div>

                </div>

                <input type="submit" value="Рег">

            </div>
            <?php $this->endWidget(); ?>

        </div>

        <div class="reg3" style="display: none;">
            УРа <span id="reg_timer">3</span>
        </div>

    </div>
</div>