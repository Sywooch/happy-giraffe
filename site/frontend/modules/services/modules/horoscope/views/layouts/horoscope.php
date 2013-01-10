<?php $this->beginContent('//layouts/main'); ?>

    <div class="main">
        <div class="main-in">

            <div id="horoscope">

                <?php echo $content; ?>

            </div>

        </div>
    </div>

    <div class="side-left">

        <div class="banner-box"><a href="<?=$this->createUrl('/horoscope') ?>"><img src="/images/horoscope_sidebar_banner.jpg"></a></div>

        <div class="well">

            <ul>
                <li><a href="<?=$this->createUrl('/services/horoscope/default/index') ?>">Гороскоп на сегодня</a></li>
                <li><a href="<?=$this->createUrl('/services/horoscope/default/tomorrow') ?>">Гороскоп на завтра</a></li>
                <li><a href="<?=$this->createUrl('/services/horoscope/default/month') ?>">Гороскоп на месяц</a></li>
                <li><a href="<?=$this->createUrl('/services/horoscope/default/year', array('year'=>2013)) ?>">Гороскоп на год</a></li>
                <li><a href="<?=$this->createUrl('/services/horoscope/compatibility/index') ?>">Гороскоп совместимости</a></li>
            </ul>

        </div>

        <?php if (Yii::app()->user->isGuest && Yii::app()->controller->id == 'compatibility' ):?>
            <div class="horoscope-subscribe">
                <img src="/images/widget/horoscope/banner-subscribe.jpg">
                <p>Хочешь иметь возможность заглянуть в своё будущее и подкорректировать его при необходимости: избежать аварии, получить хорошую прибыль, укрепить семейные отношения, вырастить прекрасных детей, то есть – реально улучшить свою жизнь?</p>
                <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'horoscope-reg-form2',
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
                                Register.showStep2($('#horoscope-reg-form2 #User_email').val(), 'horoscope');
                            }
                            return false;
                          }",
                ),
            ));?>
                <?php $user = new User ?>
                <?= $form->textField($user, 'email', array('class'=>'text', 'placeholder' => 'Введите ваш e-mail'))?>
                <?= $form->error($user, 'email')?>

                <a href="javascript:;" class="btn-amethyst btn-big" onclick="$(this).parent().submit();">Хочу!</a>
                <?php $this->endWidget(); ?>
            </div>
        <?php endif ?>

    </div>

<?php $this->endContent(); ?>