<?php
/* @var $this Controller
 * @var $model Horoscope
 */

$hideLinks = false;
if (isset($_GET['date']))
    $hideLinks = true;

$this->widget('HMenu', array(
    'seoHide'=>$hideLinks,
    'items' => array(
        array(
            'label' =>  'на сегодня',
            'url' => $this->createUrl('today', array('zodiac' => Horoscope::model()->getZodiacSlug($model->zodiac))),
            'active' => Yii::app()->controller->action->id == 'today'
        ),
        array(
            'label' =>  'на завтра',
            'url' => $this->createUrl('tomorrow', array('zodiac' => Horoscope::model()->getZodiacSlug($model->zodiac))),
            'active' => Yii::app()->controller->action->id == 'tomorrow'
        ),
        array(
            'label' =>  'на месяц',
            'url' => $this->createUrl('month', array('zodiac' => Horoscope::model()->getZodiacSlug($model->zodiac))),
            'active' => Yii::app()->controller->action->id == 'month' && empty($_GET['month'])
        ),
        array(
            'label' =>  'на 2013',
            'url' => $this->createUrl('year', array('zodiac' => Horoscope::model()->getZodiacSlug($model->zodiac), 'year' => 2013)),
            'active' => Yii::app()->controller->action->id == 'year' && (isset($_GET['year']) && $_GET['year'] == 2013)
        ),
    )));