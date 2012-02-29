<?php
/**
 * Author: alexk984
 * Date: 29.02.12
 */
class HoroscopeWidget extends CWidget
{
    /**
     * @var User
     */
    public $user = null;

    public function run()
    {
        if (empty($this->user->birthday))
            return;

        Yii::import('application.modules.horoscope.models.*');
        $user_zodiac = Horoscope::model()->getDateZodiac($this->user->birthday);
        if ($user_zodiac === null)
            return;

        if ($this->beginCache('HoroscopeWidget-' . $user_zodiac . '- ' . date("Y-m-d"), array('duration' => 3600))) {
            $criteria = new CDbCriteria;
            $criteria->compare('zodiac', $user_zodiac);
            $criteria->compare('`date`', date("Y-m-d"));
            $forecast = Horoscope::model()->find($criteria);
            if ($forecast === null)
                return;

            $this->render('horoscope', array(
                'user_zodiac' => $user_zodiac,
                'forecast' => $forecast
            ));

            $this->endCache();
        }
    }
}