<div class="reg1">
    <div class="block-title" style="text-align:center;">Регистрация на Веселом Жирафе</div>

    <div class="hl">
        <span>Стань полноправным участником сайта за 1 минуту!</span>
    </div>

    <div class="clearfix">

        <div class="register-socials">

            <div class="box-title">Регистрация через<br/>социальные сети</div>

            <?php Yii::app()->eauth->renderWidget(array('action' => 'signup/index')); ?>

        </div>

        <div class="register-mail">

            <div class="box-title">Регистрация с помощью<br/>электронной почты</div>

            <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'reg-form1',
            'action' => '#',
            'enableClientValidation' => false,
            'enableAjaxValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnChange' => true,
                'validateOnType' => true,
                'validationUrl' => Yii::app()->createUrl('/signup/validate', array('step' => 1)),
                'afterValidate' => "js:function(form, data, hasError) {
                            if (!hasError){
                                Register.redirectUrl = $('#register-redirectUrl').val();
                                Register.showStep2($('#reg-form1 #User_email').val(), 'default');
                            }
                            return false;
                          }",
            )));?>
            <?=$form->textField($model, 'email', array('class' => 'regmail1', 'placeholder' => 'Введите ваш e-mail')); ?>
            <?=CHtml::hiddenField('redirectUrl', '', array('id'=>'register-redirectUrl')); ?>
            <?=$form->error($model, 'email'); ?>
            <input type="submit" value="OK"/>
            <?php $this->endWidget(); ?>

            <ul>
                <li>Мы не любим спам</li>
                <li>Мы не передадим ваши контакты третьим лицам</li>
                <li>Вы можете изменить настройки электронной почты в любое время</li>
            </ul>

        </div>

    </div>

    <div class="is-user">
        Вы уже зарегистрированы? <a href="#login" class="fancy" data-theme="white-square">Войти</a>
    </div>

</div>

<script type="text/javascript">
    function openPopup(el) {window.open($(el).attr('href'),'','toolbar=0,status=0,width=626,height=436');return false;}
</script>