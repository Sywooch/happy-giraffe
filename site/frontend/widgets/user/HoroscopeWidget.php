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
            return ;
            Yii::import('application.modules.services.modules.horoscope.models.*');

            $user_zodiac = Horoscope::model()->getDateZodiac($this->user->birthday);
            if ($user_zodiac === null)
                return;

//            if (CController::beginCache('HoroscopeWidget-' . $user_zodiac . '- ' . date("Y-m-d"), array('duration' => 3600))) {
                $criteria = new CDbCriteria;
                $criteria->compare('zodiac', $user_zodiac);
                $criteria->compare('`date`', date("Y-m-d"));
                $forecast = Horoscope::model()->find($criteria);
                if ($forecast === null)
                    return;

                $this->render('HoroscopeWidget', array(
                    'user_zodiac' => $user_zodiac,
                    'forecast' => $forecast
                ));

//                CController::endCache();
//            }

    }
}