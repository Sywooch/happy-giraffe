<?php
class RegisterWidget extends CWidget
{
    public $show_form = false;
    public $odnoklassniki = false;

    public function run()
    {
        echo Yii::app()->controller->uniqueId;
        if (Yii::app()->user->isGuest) {
            if (strpos(Yii::app()->getRequest()->urlReferrer, 'http://www.odnoklassniki.ru/') === 0) {
                $this->odnoklassniki = true;
            } elseif (!empty(Yii::app()->getRequest()->urlReferrer) && strpos(Yii::app()->getRequest()->urlReferrer, 'http://'.$_SERVER['SERVER_NAME'].'/') !== 0) {
                Yii::app()->user->setState('show_register_window', 1);
            } elseif (Yii::app()->user->getState('show_register_window') == 1 && !empty(Yii::app()->request->urlReferrer)) {
                Yii::app()->user->setState('show_register_window', 0);
                $this->show_form = true;
            }

            if (Yii::app()->user->getState('ban_register_window') == 1){
                Yii::app()->user->setState('show_register_window', 0);
                Yii::app()->user->setState('ban_register_window', 0);
                $this->show_form = false;
            }

            $model = new User;
            $this->render('form', array(
                'model' => $model,
                'odnoklassniki' => $this->odnoklassniki,
            ));
        }
    }

    public function inHoroscopeArea()
    {
        return Yii::app()->controller->uniqueId == 'services/horoscope/default';
    }

    public function inPregnancyArea()
    {
        return
            (Yii::app()->controller->uniqueId == 'services/calendar/default' && $_GET['calendar'] == 1) //календрарь беременности
            || (Yii::app()->controller->uniqueId == 'services/calendar/default');
    }
}
