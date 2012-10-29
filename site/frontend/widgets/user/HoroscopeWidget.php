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

        $cache_id = 'HoroscopeWidget-' . $user_zodiac . '- ' . date("Y-m-d");
        $value=Yii::app()->cache->get($cache_id);
        if($value===false)
        {
            $criteria = new CDbCriteria;
            $criteria->compare('zodiac', $user_zodiac);
            $criteria->compare('`date`', date("Y-m-d"));
            $forecast = Horoscope::model()->find($criteria);
            if ($forecast === null)
                return;

            $value = $this->render('HoroscopeWidget', array(
                'user_zodiac' => $user_zodiac,
                'forecast' => $forecast
            ), true);

            Yii::app()->cache->set($cache_id,$value, 3600);
        }

        echo $value;
    }
}