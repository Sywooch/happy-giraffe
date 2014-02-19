<?php
class RegisterWidget extends CWidget
{
    public $show_form = false;
    public $form_type = 'default';

    public function run()
    {
        return;
        if (Yii::app()->user->isGuest) {
            //for tests
            //Yii::app()->user->setState('register_window_shown', 0);

            if (! Yii::app()->request->cookies->contains('registerWindowShown') && ! Yii::app()->request->cookies->contains('not_guest') && Yii::app()->user->getState('viewsCount') == 2) {
                if (!empty(Yii::app()->getRequest()->urlReferrer) && $this->inHoroscopeArea()) {
//                    $this->show_form = true;
//                    $this->form_type = 'horoscope';
                } elseif (!empty(Yii::app()->getRequest()->urlReferrer) && $this->inPregnancyArea()) {
//                    $this->show_form = true;
//                    $this->form_type = 'pregnancy';
                } elseif (strpos(Yii::app()->getRequest()->urlReferrer, 'http://www.odnoklassniki.ru/') === 0) {
//                    $this->form_type = 'odnoklassniki';
//                    $this->show_form = true;
                } elseif (!empty(Yii::app()->getRequest()->urlReferrer)) {
                }
                $this->show_form = true;
            }

            if ($this->show_form)
                Yii::app()->request->cookies['registerWindowShown'] = new CHttpCookie('registerWindowShown', 1);

            //$this->show_form = false;

            $model = new User;
            $this->render('form', array(
                'model' => $model,
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
            (Yii::app()->controller->uniqueId == 'calendar/default' && $_GET['calendar'] == 1) //календрарь беременности
            || (Yii::app()->controller->uniqueId == 'services/babySex/default') //определение пола будущего ребенка
            || (Yii::app()->controller->uniqueId == 'services/pregnancyWeight/default') //вес при беременности
            || (Yii::app()->controller->uniqueId == 'services/placentaThickness/default') //толщины плаценты
            || (Yii::app()->controller->uniqueId == 'services/maternityLeave/default') //Когда уходить в декрет
            || (Yii::app()->controller->uniqueId == 'services/test/default' && $_GET['slug'] == 'pregnancy') //Онлайн-тест на беременность
            || (Yii::app()->controller->uniqueId == 'services/contractionsTime/default') //Считаем схватки
            || (Yii::app()->controller->uniqueId == 'services/names/default') //Выбор имени ребенка
            || (Yii::app()->controller->uniqueId == 'community' && isset($_GET['community_id']) && in_array($_GET['community_id'], array(1, 2, 3))) //Выбор имени ребенка
            ;
    }
}