<?php
/**
 * @var $model Horoscope
 */
?><?php $time = strtotime($model->date); ?>
<div class="b-main_cont">
    <div class="b-main_col-article">
        <h1 class="heading-link-xxl"><?= '' ?></h1>
        <div class="horoscope-day">
            <div class="ico-zodiac ico-zodiac__xl">
                <div class="ico-zodiac_in ico-zodiac__<?= $model->zodiac ?>"></div>
            </div>
            <div class="horoscope-day_tx"><?= $model->zodiacText() ?></div>
        </div>
        <div class="wysiwyg-content clearfix">
            <?php
            if (Yii::app()->controller->action->id != 'date')
            {
                $this->beginWidget('SeoContentWidget');
                echo Str::strToParagraph($model->text);
                $this->endWidget();
            }
            ?>
            <p><?= $model->getAdditionalText() ?></p>
        </div>
        <!-- Лайки от янжекса-->
        <?php $this->widget('application.widgets.yandexShareWidget.YandexShareWidget', array('model' => $model, 'title' => $this->social_title)); ?>

        <div class="menu-link-simple menu-link-simple__center">
            <div class="menu-link-simple_t">Еще Овен</div>
            <?php $this->renderPartial('_menu'); ?>
        </div>
        <div class="seo-desc wysiwyg-content visible-md-block">
            <?= $model->getText(); ?>
        </div>
        <!-- Реклама яндекса-->
        <?php $this->renderPartial('//banners/_horoscope'); ?>
    </div>
    <!-- /Основная колонка-->
    <div class="b-main_col-sidebar">
        <!-- Зодиаки-->
        <div class="zodiac-list zodiac-list__sidebar">
            <?php $this->renderPartial('_zodiac_list'); ?>
        </div>
        <!-- Зодиаки-->
    </div>
</div>
    <?php /*
<div class="horoscope-one">

    <div class="block-in">

        <div class="img">

            <div class="in"><img src="/images/widget/horoscope/big/<?= $model->zodiac ?>.png"></div>
            <div class="date"><span><?= $model->zodiacText() ?></span><?= $model->zodiacDates() ?></div>

        </div>

        <div class="dates">
            <?php $this->renderPartial('_menu') ?>
        </div>

        <div class="text clearfix">
            <div class="date">
                <span><?= date("j", strtotime($model->date)) ?></span>
                <?= HDate::ruMonthShort(date("n", strtotime($model->date))) ?>
            </div>
            <div class="holder">
                <?php if (Yii::app()->controller->action->id != 'date') $this->beginWidget('SeoContentWidget'); ?>
                <?= Str::strToParagraph($model->text) ?>
                <?php if (Yii::app()->controller->action->id != 'date') $this->endWidget(); ?>
                <p><?= $model->getAdditionalText() ?></p>

                <?php if (Yii::app()->controller->action->id == 'date'): ?>
                    <div class="dates clearfix">
                        <?php $prev = strtotime('-1 day', strtotime($model->date)); ?>
                        <?php if ($model->dateHoroscopeExist($prev)): ?>
                            <span class="a-left"><?= $model->getDateLink($prev) ?></span>
                        <?php endif ?>
                        <?php $next = strtotime('+1 day', strtotime($model->date)); ?>
                        <?php if ($model->dateHoroscopeExist($next)): ?>
                            <span class="a-right"><?= $model->getDateLink($next) ?></span>
                        <?php endif ?>


                        <?php $prev = strtotime('-2 days', strtotime($model->date)); ?>
                        <?php if ($model->dateHoroscopeExist($prev)): ?>
                            <span class="a-left"><?= $model->getDateLink($prev) ?></span>
                        <?php endif ?>

                        <?php $next = strtotime('+2 days', strtotime($model->date)); ?>
                        <?php if ($model->dateHoroscopeExist($next)): ?>
                            <span class="a-right"><?= $model->getDateLink($next) ?></span>
                        <?php endif ?>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <?php if (Yii::app()->controller->action->id == 'yesterday'): ?>
            <div class="horoscope-daylist clearfix">
                <ul>
                    <?php for ($i = 2; $i < 10; $i++): ?>
                        <li><?= $model->getDateLink(strtotime('-' . $i . ' days')) ?></li>
                    <?php endfor; ?>
                </ul>
            </div>
        <?php endif ?>

        <?php $this->widget('application.widgets.yandexShareWidget.YandexShareWidget', array('model' => $model, 'title' => $this->social_title)); ?>

    </div>

</div>

<?php $this->renderPartial('_bottom_list', array('model' => $model)); ?>

<?php if (Yii::app()->controller->action->id != 'date'): ?>
    <div class="wysiwyg-content">

        <?= $model->getText(); ?>

    </div>
<?php endif ?>

<div class="horoscope-otherday">
    <?= $model->getDateLinks() ?>
</div>-->*/
