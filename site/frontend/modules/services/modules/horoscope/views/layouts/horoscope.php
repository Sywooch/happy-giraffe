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
                <li><a href="<?=$this->createUrl('/services/horoscope/default/compatibility') ?>">Гороскоп совместимости</a></li>
            </ul>

        </div>

        <?php if (Yii::app()->user->isGuest):?>
            <div class="horoscope-subscribe">
                <img src="/images/horoscope_subscribe_banner.jpg">
                <p>Хочешь иметь возможность заглянуть в своё будущее и подкорректировать его при необходимости: избежать аварии, получить хорошую прибыль, укрепить семейные отношения, вырастить прекрасных детей, то есть – реально улучшить свою жизнь?</p>
                <a href="#register" class="fancy btn-want" data-theme="white-square">Хочу!</a>
            </div>
        <?php endif ?>

    </div>

<?php $this->endContent(); ?>