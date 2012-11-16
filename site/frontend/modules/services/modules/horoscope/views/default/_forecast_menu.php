<?php
/* @var $this Controller
 * @var $model Horoscope
 */
?><?php $this->widget('zii.widgets.CMenu', array(
    'items' => array(
        array(
            'label' => 'На сегодня',
            'url' => $this->createUrl('today', array('zodiac' => Horoscope::model()->getZodiacSlug($model->zodiac))),
            'active' => Yii::app()->controller->action->id == 'today'
        ),
        array(
            'label' => 'На завтра',
            'url' => $this->createUrl('tomorrow', array('zodiac' => Horoscope::model()->getZodiacSlug($model->zodiac))),
            'active' => Yii::app()->controller->action->id == 'tomorrow'
        ),
        array(
            'label' => 'На месяц',
            'url' => $this->createUrl('month', array('zodiac' => Horoscope::model()->getZodiacSlug($model->zodiac))),
            'active' => Yii::app()->controller->action->id == 'month' && empty($_GET['month'])
        ),
        array(
            'label' => 'На 2012',
            'url' => $this->createUrl('year', array('zodiac' => Horoscope::model()->getZodiacSlug($model->zodiac))),
            'active' => Yii::app()->controller->action->id == 'year' && empty($_GET['year'])
        ),
    )));