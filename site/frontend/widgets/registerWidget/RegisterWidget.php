<?php
class RegisterWidget extends CWidget
{
    public $show_form = false;
    public $odnoklassniki = false;
    public $type = 'default';

    public $template = array(
        'default' => array(
            'step1' => array(
                'title1' => 'Регистрация на Веселом Жирафе',
                'title2' => 'Стань полноправным участником сайта за 1 минуту!',
            ),
            'step2' => array(
                'title1' => 'Вы уже почти с нами!',
                'title2' => 'Осталось ввести ваши имя, фамилию, пол и пароль',
            ),
            'step3' => array(
                'title1' => 'Вы готовим для вас личную страницу',
            ),
            'inputBirthday'=>false
        ),

        'horoscope' => array(
            'step1' => array(
                'title1' => 'Хочу гороскоп каждый день',
                'title2' => 'Зарегистрируйтесь, чтобы получать гороскоп!',
            ),
            'step2' => array(
                'title1' => 'Ваш гороскоп почти готов!',
                'title2' => 'Осталось ввести ваши имя, фамилию, пол, дату рождения и пароль',
            ),
            'step3' => array(
                'title1' => 'Вы готовим для вас гороскоп',
            ),
            'inputBirthday'=>true
        ),
    );

    public function run()
    {
        if (Yii::app()->user->isGuest) {
            if (Yii::app()->controller->uniqueId == 'services/horoscope/default'){
                $this->type = 'horoscope';
            }
            elseif (strpos(Yii::app()->getRequest()->urlReferrer, 'http://www.odnoklassniki.ru/') === 0) {
                $this->odnoklassniki = true;
            }

            $model = new User;
            $this->render('form', array(
                'model' => $model,
                'odnoklassniki' => $this->odnoklassniki,
                'type'=>$this->type
            ));
        }
    }
}
