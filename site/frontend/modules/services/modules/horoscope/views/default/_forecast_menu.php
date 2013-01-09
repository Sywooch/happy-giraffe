<?php
/* @var $this Controller
 * @var $model Horoscope
 */
$this->widget('zii.widgets.CMenu', array(
    'items' => array(
        array(
            'label' => $model->zodiacText() . ' на сегодня',
            'url' => $this->createUrl('today', array('zodiac' => Horoscope::model()->getZodiacSlug($model->zodiac))),
            'active' => Yii::app()->controller->action->id == 'today'
        ),
        array(
            'label' => $model->zodiacText() . ' на завтра',
            'url' => $this->createUrl('tomorrow', array('zodiac' => Horoscope::model()->getZodiacSlug($model->zodiac))),
            'active' => Yii::app()->controller->action->id == 'tomorrow'
        ),
        array(
            'label' => $model->zodiacText() . ' на месяц',
            'url' => $this->createUrl('month', array('zodiac' => Horoscope::model()->getZodiacSlug($model->zodiac))),
            'active' => Yii::app()->controller->action->id == 'month' && empty($_GET['month'])
        ),
        array(
            'label' => $model->zodiacText() . ' на 2013',
            'url' => $this->createUrl('year', array('zodiac' => Horoscope::model()->getZodiacSlug($model->zodiac), 'year' => 2013)),
            'active' => Yii::app()->controller->action->id == 'year' && $_GET['year'] == 2013
        ),
    )));