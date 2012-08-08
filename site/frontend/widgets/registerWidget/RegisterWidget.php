<?php
class RegisterWidget extends CWidget
{
    public $show_form = false;
    public $odnoklassniki = false;

    public function run()
    {
        if (Yii::app()->user->isGuest) {
            if (strpos(Yii::app()->getRequest()->urlReferrer, 'http://www.odnoklassniki.ru/') === 0) {
                //чел пришел из одноклассников
                $this->show_form = true;
                $this->odnoklassniki = true;
                Yii::app()->user->setState('redirectUrl', Yii::app()->request->getRequestUri());
            }
            if (strpos(Yii::app()->getRequest()->urlReferrer, 'http://'.$_SERVER['HTTP_HOST']) === false) {
                //чел пришел с другого сайта, предлагаем зарегаться
                if (Yii::app()->controller->module->id == 'services/horoscope')
                    $this->show_form = true;
            }
            $model = new User;
            $this->render('form', array('model' => $model, 'show_form' => $this->show_form, 'odnoklassniki'=>$this->odnoklassniki));
        }
    }
}
