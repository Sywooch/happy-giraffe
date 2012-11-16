<?php
/**
 * Author: alexk984
 * Date: 29.02.12
 */
class HoroscopeWidget extends UserCoreWidget
{
    public function init()
    {
        parent::init();
        $this->visible = !empty($this->user->birthday);
    }

    public function run()
    {
        if (!$this->visible)
            return;
        Yii::import('application.modules.services.modules.horoscope.models.*');

        $user_zodiac = Horoscope::model()->getDateZodiac($this->user->birthday);
        if ($user_zodiac === null)
            return;

        if (Yii::app()->user->isGuest)
            $show_horoscope = false;
        else {
            $show_horoscope = UserAttributes::get(Yii::app()->user->id, 'horoscope');
            if (strpos($show_horoscope, date("Y-m-d")) === false)
                $show_horoscope = false;
            else
                $show_horoscope = true;
        }

        if ($show_horoscope) {
            $cache_id = 'HoroscopeWidget-' . $user_zodiac . '- ' . date("Y-m-d");
            $value = Yii::app()->cache->get($cache_id);
        } else
            $value = false;

        if ($value === false) {
            $criteria = new CDbCriteria;
            $criteria->compare('zodiac', $user_zodiac);
            $criteria->compare('`date`', date("Y-m-d"));
            $horoscope = Horoscope::model()->find($criteria);
            if ($horoscope === null)
                return;

            $value = $this->render('HoroscopeWidget', array(
                'user_zodiac' => $user_zodiac,
                'horoscope' => $horoscope,
                'show_horoscope' => $show_horoscope
            ), true);

            if ($show_horoscope)
                Yii::app()->cache->set($cache_id, $value, 5 * 3600);
        }

        echo $value;
    }
}