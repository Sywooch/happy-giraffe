<?php
class RegisterWidget extends CWidget
{
    public function run()
    {
        if(Yii::app()->user->isGuest)
        {
            if (strpos(Yii::app()->getRequest()->urlReferrer, 'http://www.odnoklassniki.ru/') === 0){
                //чел пришел из одноклассников
                Yii::app()->user->setState('comes_from_social', 'odnoklassniki');
            }
            $model = new User;
            $this->render('form', array('model' => $model));
        }
    }
}
