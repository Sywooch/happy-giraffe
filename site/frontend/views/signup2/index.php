<div class="title">Регистрация</div>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'signup',
    'action' => $this->createUrl('signup2/finish', array('redirectUrl' => Yii::app()->request->getQuery('redirectUrl') ? Yii::app()->request->getQuery('redirectUrl') : '')),
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => true,
        'validationUrl' => $this->createUrl('signup2/validate'),
        'afterValidate' => "js:function(form, data, hasError) {
                                    if (!hasError)
                                        SignUp.send();
                                    return false;
                                  }",
    ))); ?>

    <div class="form" id="step_1">

        <div class="clearfix">
            <?php if ($regdata === null): ?>
                <div class="a-right login-social">

                    <span>Войти с помощью<br/>социальной сети</span>

                    <div class="fast-login socials socials-inline">
                        <?php Yii::app()->eauth->renderWidget(array('action' => 'signup/index')); ?>
                    </div>

                </div>

                <div class="form-in clearfix">

                    <div class="row clearfix">
                        <div class="row-title">Ваше имя:</div>
                        <div class="row-elements">
                            <?php echo $form->textField($model, 'first_name'); ?>
                            <?php echo $form->error($model, 'first_name'); ?>
                            <div class="row-bottom">Укажите ваше настоящее имя, до 50 символов.</div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="row-title">Ваш e-mail:</div>
                        <div class="row-elements">
                            <?php echo $form->textField($model, 'email'); ?>
                            <?php echo $form->error($model, 'email'); ?>
                            <div class="row-bottom">Укажите реальный и действующий e-mail адрес.</div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="row-title">Ваш пароль:</div>
                        <div class="row-elements">
                            <?php echo $form->passwordField($model, 'password'); ?>
                            <?php echo $form->error($model, 'password'); ?>
                            <div class="row-bottom">Придумайте сложный пароль, который нельзя подобрать, <br/>от 6 до 12 символов — цифры и английские буквы.</div>
                        </div>

                    </div>

                </div>
            <?php else: ?>
                <?php echo $form->hiddenField($model, 'name', array('value' => $regdata['name'])); ?>
                <?php if (isset($regdata['first_name'])) echo $form->hiddenField($model, 'first_name', array('value' => $regdata['first_name'])); ?>
                <?php if (isset($regdata['last_name'])) echo $form->hiddenField($model, 'last_name', array('value' => $regdata['last_name'])); ?>
                <?php if (isset($regdata['birthday'])) echo $form->hiddenField($model, 'birthday', array('value' => $regdata['birthday'])); ?>
                <?php if (isset($regdata['avatar'])) echo $form->hiddenField($model, 'avatar', array('value' => $regdata['avatar'])); ?>

                <div class="user-info">
                    <?php if (isset($regdata['photo'])): ?><a style="float: left" href="javascript:;"><?php echo CHtml::image($regdata['photo']); ?></a><?php endif; ?>
                    <div class="details">
                        <a href="javascript:;" class="username"><?php echo $regdata['name']; ?></a>
                    </div>
                </div>

                <div style="margin-left:200px;">
                    <div class="row clearfix">
                        <div class="row-title">Ваш e-mail:</div>
                        <div class="row-elements">
                            <?php echo $form->textField($model, 'email', array('value' => isset($regdata['email']) ? $regdata['email'] : '')); ?>
                            <?php echo $form->error($model, 'email'); ?>
                            <div class="row-bottom">Укажите реальный и действующий e-mail адрес.</div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="row-title">Ваш пароль:</div>
                        <div class="row-elements">
                            <?php echo $form->passwordField($model, 'password'); ?>
                            <?php echo $form->error($model, 'password'); ?>
                            <div class="row-bottom">Придумайте сложный пароль, который нельзя подобрать, <br/>от 6 до 12 символов — цифры и английские буквы.</div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-bottom">
            <button class="btn btn-green-medium" id="next_1"><span><span>Продолжить<i class="arr-r"></i></span></span></button>
        </div>
    </div>

<?php $this->endWidget(); ?>