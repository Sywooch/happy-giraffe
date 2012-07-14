<?php
/* @var $this Controller
 * @var $model Horoscope
 */
?><?php $this->widget('zii.widgets.CMenu', array(
    'items' => array(
        array(
            'label' => 'На вчера',
            'url' => $this->createUrl('yesterday', array('zodiac' => Horoscope::getZodiacSlug($model->zodiac))),
            'active' => Yii::app()->controller->action->id == 'yesterday'
        ),
        array(
            'label' => 'На сегодня',
            'url' => $this->createUrl('view', array('zodiac' => Horoscope::getZodiacSlug($model->zodiac))),
            'active' => Yii::app()->controller->action->id == 'view'
        ),
        array(
            'label' => 'На завтра',
            'url' => $this->createUrl('tomorrow', array('zodiac' => Horoscope::getZodiacSlug($model->zodiac))),
            'active' => Yii::app()->controller->action->id == 'tomorrow'
        ),
        array(
            'label' => 'На месяц',
            'url' => $this->createUrl('month', array('zodiac' => Horoscope::getZodiacSlug($model->zodiac))),
            'active' => Yii::app()->controller->action->id == 'month'
        ),
        array(
            'label' => 'На 2012',
            'url' => $this->createUrl('year', array('zodiac' => Horoscope::getZodiacSlug($model->zodiac))),
            'active' => Yii::app()->controller->action->id == 'year'
        ),
    )));?>