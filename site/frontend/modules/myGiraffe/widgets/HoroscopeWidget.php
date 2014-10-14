<?php

/**
 * Class HoroscopeWidget
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class HoroscopeWidget extends CWidget
{
    /**
     * @var User
     */
    private $user;
    public $title;

    public function run()
    {
        $this->user = Yii::app()->user->getModel();
        $horoscope_seen = UserAttributes::get($this->user->id, 'horoscope_seen');
        $horoscope_subscribe = UserAttributes::get($this->user->id, 'horoscope_subscribe', 1);

        if (!$horoscope_seen && $horoscope_subscribe && !empty($this->user->birthday) && date("H") < 13) {
            Yii::import('application.modules.services.modules.horoscope.models.*');
            $user_zodiac = Horoscope::model()->getDateZodiac($this->user->birthday);

            $criteria = new CDbCriteria;
            $criteria->compare('zodiac', $user_zodiac);
            $criteria->compare('`date`', date("Y-m-d"));
            $horoscope = Horoscope::model()->find($criteria);
            if ($horoscope !== null) {
                $this->title = 'Гороскоп ' . $horoscope->zodiacText2() . ' на сегодня ';

                UserAttributes::set(Yii::app()->user->id, 'horoscope_seen', 1);

                $this->render('HoroscopeWidget', array('user' => $this->user, 'horoscope' => $horoscope));
            }
        }
    }
}
