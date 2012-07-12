<?php
/* @var $model HoroscopeCompatibility
 * @var $form CActiveForm
 */

Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
?>
<div id="horoscope">

    <?php $this->renderPartial('_compatibility_form', compact('model')); ?>

    <div class="wysiwyg-content">

        <h1>Гороскоп совместимости</h1>

        <div id="result">

        </div>
    </div>
    <br>

    <div class="clearfix">

        <div class="horoscope-compatibility-list">
            <ul>
                <?php foreach (Horoscope::model()->zodiac_list as $key => $zodiac): ?>
                <li>
                    <div class="img">
                        <img src="/images/widget/horoscope/smaller/<?=$key ?>.png">

                        <div class="date"><span><?=$zodiac ?></span><?=Horoscope::model()->someZodiacDates($key) ?>
                        </div>
                    </div>
                    <ul>
                        <?php foreach (Horoscope::model()->zodiac_list as $key2 => $zodiac2): ?>
                        <li><a href="<?=$model->getUrl($key, $key2) ?>"><?=$zodiac ?> - <?=$zodiac2 ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>

</div>