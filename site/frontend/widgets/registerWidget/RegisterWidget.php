<?php
class RegisterWidget extends CWidget
{
    public $show_form = false;

    public function run()
    {
        if (Yii::app()->user->isGuest) {
            if (strpos(Yii::app()->getRequest()->urlReferrer, 'http://www.odnoklassniki.ru/') === 0) {
                //чел пришел из одноклассников
                $this->show_form = true;
                Yii::app()->user->setState('comes_from_social', 'odnoklassniki');
            }
            if (strpos(Yii::app()->getRequest()->urlReferrer, 'http://'.$_SERVER['HTTP_HOST']) === false) {
                //чел пришел с другого сайта, предлагаем зарегаться
                $this->show_form = true;
            }
            $model = new User;
            $this->render('form', array('model' => $model, 'show_form' => $this->show_form));
        }
    }
}
