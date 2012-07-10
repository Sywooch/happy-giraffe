<?php
/* @var $model HoroscopeCompatibility
 * @var $form CActiveForm
 */
Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

?>
<div id="horoscope">

    <?php $this->renderPartial('_compatibility_form', compact('model')); ?>

    <div class="wysiwyg-content">

        <h2>Гороскоп совместимости</h2>

        <div id="result">
            <?php if (!empty($model->text)) echo Str::strToParagraph($model->text); ?>
        </div>
    </div>

    <div class="clearfix">

        <div class="fast-horoscope">

            <div class="block-title">
                <div class="in">Гороскоп<br>на сегодня</div>
                <div class="date"><b><?=Yii::app()->dateFormatter->format('d', time()) ?></b><br><?=Yii::app()->dateFormatter->format('MMMM', time()) ?></div>
            </div>

            <ul>

                <?php
                $horoscope = Horoscope::model()->findByAttributes(array('zodiac'=>$model->zodiac1,'date'=>date("Y-m-d")));
                $this->renderPartial('_preview',array('model'=>$horoscope));
                $horoscope = Horoscope::model()->findByAttributes(array('zodiac'=>$model->zodiac2,'date'=>date("Y-m-d")));
                $this->renderPartial('_preview',array('model'=>$horoscope));                ?>

            </ul>

        </div>

        <div class="horoscope-compatibility-list wide">
            <ul>
                <?php $this->renderPartial('_compatibility_links',array('zodiac'=>$model->zodiac1)); ?>
                <?php $this->renderPartial('_compatibility_links',array('zodiac'=>$model->zodiac2)); ?>
            </ul>
        </div>

    </div>

</div>