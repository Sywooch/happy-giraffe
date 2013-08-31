<?php
/* @var $model HoroscopeCompatibility
 * @var $form CActiveForm
 */
?>
<div id="horoscope">

    <?php $this->renderPartial('_compatibility_form', compact('model')); ?>

    <div class="wysiwyg-content">

        <h1>Гороскоп совместимости &mdash; <?=Horoscope::model()->zodiac_list[$model->zodiac1].' и '.Horoscope::model()->zodiac_list[$model->zodiac2] ?></h1>

        <div id="result">
            <?php if (!empty($model->text)) echo $model->text; ?>
        </div>
    </div>
    <br>

    <div class="clearfix">

        <div class="fast-horoscope">

            <div class="block-title">
                <div class="in">Гороскоп<br>на сегодня</div>
                <div class="date"><b><?=Yii::app()->dateFormatter->format('d', time()) ?></b><br><?=HDate::ruMonthShort(date('n'))?></div>
            </div>

            <ul>

                <?php
                $horoscope = Horoscope::model()->findByAttributes(array('zodiac'=>$model->zodiac1,'date'=>date("Y-m-d")));
                $this->renderPartial('preview',array('model'=>$horoscope));
                if ($model->zodiac1 != $model->zodiac2){
                    $horoscope = Horoscope::model()->findByAttributes(array('zodiac'=>$model->zodiac2,'date'=>date("Y-m-d")));
                    $this->renderPartial('preview',array('model'=>$horoscope));
                }?>

            </ul>

        </div>

        <div class="horoscope-compatibility-list wide">
            <ul>
                <?php $this->renderPartial('_compatibility_links',array('zodiac'=>$model->zodiac1)); ?>
                <?php if ($model->zodiac1 != $model->zodiac2)
                        $this->renderPartial('_compatibility_links',array('zodiac'=>$model->zodiac2)); ?>
            </ul>
        </div>

    </div>

</div>