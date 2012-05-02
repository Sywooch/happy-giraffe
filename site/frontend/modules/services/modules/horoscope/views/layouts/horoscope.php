<?php $this->beginContent('//layouts/main'); ?>

    <?php /*$this->widget('zii.widgets.CBreadcrumbs', array(
        'links' => $this->breadcrumbs,
        'separator' => ' &gt; ',
        'htmlOptions' => array(
            'id' => 'crumbs',
            'class' => null,
        ),
    ));*/ ?>

    <div class="main">
        <div class="main-in">

            <div id="horoscope">

                <?php echo $content; ?>

            </div>

        </div>
    </div>

    <div class="side-left">

        <div class="banner-box"><a href=""><img src="/images/horoscope_sidebar_banner.jpg"></a></div>

        <div class="horoscope-subscribe">
            <img src="/images/horoscope_subscribe_banner.jpg">
            <p>Хочешь иметь возможность заглянуть в своё будущее и подкорректировать его при необходимости: избежать аварии, получить хорошую прибыль, укрепить семейные отношения, вырастить прекрасных детей, то есть – реально улучшить свою жизнь?</p>
            <a href="" class="btn-want">Хочу!</a>
        </div>

    </div>

<?php $this->endContent(); ?>