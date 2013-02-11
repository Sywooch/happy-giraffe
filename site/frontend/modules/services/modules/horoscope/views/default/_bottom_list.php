<?php if (Yii::app()->user->isGuest): ?>
<?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'horoscope-reg-form',
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
                                Register.showStep2($('#horoscope-reg-form #User_email').val(), 'horoscope');
                            }
                            return false;
                          }",
        ),
        'htmlOptions' => array(
            'class' => 'horoscope-subscribe-big'
        )
    ));?>
    <?php $user = new User ?>
    <input type="submit" value="Хочу!" class="submit btn-amethyst btn-big ">
    <label for="horoscope-email">Хочешь получать гороскоп каждый день?</label>

    <?= $form->textField($user, 'email', array('class' => 'inptext', 'placeholder' => 'Введите ваш e-mail'))?>
    <?= $form->error($user, 'email')?>
<?php $this->endWidget(); ?>
<?php endif ?><?php $type = $model->getType() ?>
<div class="horoscope-fast-list clearfix">

    <div class="title">Все знаки зодиака</div>

    <ul>
        <li>
            <div class="other">Смотреть другие знаки</div>
        </li>
        <?php for ($i = 1; $i <= 12; $i++) if ($i != $model->zodiac) { ?>
        <li>
            <?= HHtml::link('<img src="/images/widget/horoscope/small/'.$i.'.png"><br><span>'.
            Horoscope::getZodiacTitle($i).'</span><br> '. $model->zodiacDates(),
            $model->getOtherZodiacUrl(Horoscope::model()->getZodiacSlug($i)),
            array('title'=>$model->getOtherZodiacTitle($i)), true) ?>
        </li>
        <?php } ?>
    </ul>

</div>