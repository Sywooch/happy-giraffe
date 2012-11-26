<div style="display: none;">
    <div id="pregnancy-calendar-self" class="popup">

        <a href="javascript:void(0);" class="popup-close tooltip" onclick="$.fancybox.close()"></a>

        <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'pregnancy-register-form',
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
                                    Register.showStep2($('#pregnancy-register-form #User_email').val(), 'pregnancy');
                                }
                                return false;
                              }",
        ),
        'htmlOptions' => array(
            'class' => 'clearfix'
        )
    ));?>
        <div class="banner-mail">
            <img src="/images/pregnancy-calendar.jpg" alt="" width="390" height="270">
            <div class="mail-holder">
                <?= $form->textField($model, 'email', array('class' => 'text', 'placeholder' => 'Введите ваш e-mail адрес'))?>
                <?= $form->error($model, 'email')?>
            </div>
        </div>
        <div class="right-col">
            <div class="free">БЕСПЛАТНО!</div>
            <div class="calendar-title">Персональный календарь беременности</div>
            <div class="social-small-row clearfix">
                <em>войти с помощью</em>
                <ul class="social-list-small">
                    <?php Yii::app()->eauth->renderWidget(array('action' => 'signup/index/type/pregnancy', 'mode'=>'small')); ?>
                </ul>
            </div>
            <input type="submit" value="Продолжить" class="submit btn-green">
        </div>
        <?php $this->endWidget(); ?>
        <div class="is-user">
            Вы уже зарегистрированы? <a href="#login" class="fancy" data-theme="white-square">Войти</a>
        </div>
    </div>
</div>