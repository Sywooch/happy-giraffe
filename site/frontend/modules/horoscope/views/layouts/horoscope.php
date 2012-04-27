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
            <p>Хочешь советоваться со звёздами ежедневно?</p>
            <a href="" class="btn-want">Хочу!</a>
        </div>

    </div>

<?php $this->endContent(); ?>