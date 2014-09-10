<?php $this->beginContent('//layouts/main'); ?>

    <div class="b-section">
        <div class="b-section_hold">
            <div class="content-cols clearfix">
                <div class="col-1">
                    <div class="club-list club-list__big clearfix">
                        <ul class="club-list_ul textalign-c clearfix">
                            <li class="club-list_li">
                                <a href="<?=$this->createUrl('/horoscope') ?>" class="club-list_i">
                                    <span class="club-list_img-hold">
                                        <img src="/images/widget/horoscope/horoscope-title-w130.png" alt="" class="club-list_img">
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-23-middle">
                    <div class="padding-l20">
                        <h1 class="b-section_t">Гороскопы <br> от Веселого Жирафа</h1>
                        <div class="margin-t10 color-gray-dark clearfix">
                            Самые правдивые астрологические прогнозы для всех знаков Зодиака на каждый день
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-cols">
        <div class="col-1">

            <div class="menu-simple">
                <?php $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array(
                            'label' => 'Гороскоп на сегодня',
                            'url' => array('/services/horoscope/default/index'),
                            'linkOptions' => array('class' => 'menu-simple_a'),
//                            'active' => Yii::app()->controller->action->id  === 'index' && Yii::app()->controller->id == 'default',
                        ),
                        array(
                            'label' => 'Гороскоп на завтра',
                            'url' => array('/services/horoscope/default/tomorrow'),
                            'linkOptions' => array('class' => 'menu-simple_a'),
//                            'active' => Yii::app()->controller->action->id  === 'tomorrow',
                        ),
                        array(
                            'label' => 'Гороскоп на месяц',
                            'url' => array('/services/horoscope/default/month'),
                            'linkOptions' => array('class' => 'menu-simple_a'),
//                            'active' => Yii::app()->controller->action->id  === 'month',
                        ),
                        array(
                            'label' => 'Гороскоп на год',
                            'url' => array('/services/horoscope/default/year', 'year'=>2013),
                            'linkOptions' => array('class' => 'menu-simple_a'),
//                            'active' => Yii::app()->controller->action->id  === 'year',
                        ),
                        array(
                            'label' => 'Гороскоп совместимости',
                            'url' => array('/services/horoscope/compatibility/index'),
                            'linkOptions' => array('class' => 'menu-simple_a'),
//                            'active' => Yii::app()->controller->action->id  === 'index' && Yii::app()->controller->id == 'compatibility',
                        ),
                    ),
                    'itemCssClass' => 'menu-simple_li',
                    'htmlOptions' => array('class' => 'menu-simple_ul')
                ));

                ?>
            </div>

            <div class="banner-box padding-t20">
                <?php //$this->renderPartial('//banners/adfox'); ?>
            </div>

        </div>

        <div class="col-23-middle clearfix">
            <div class="col-gray padding-20">
                <div id="horoscope">

                    <?php if (! empty($this->title)): ?>
                    <h1 class="heading-title clearfix"><?= $this->title ?></h1>
                    <?php endif; ?>

                    <?=$content ?>

                </div>
            </div>
        </div>
    </div>

<?php $this->endContent(); ?>