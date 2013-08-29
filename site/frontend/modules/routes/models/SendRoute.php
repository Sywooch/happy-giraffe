<?php
/**
 * Author: alexk984
 * Date: 19.02.13
 */
class SendRoute extends CModel
{
    // результат проверки
    public $own_email;
    public $friend_email;
    public $route_id;
    public $message;


    function rules()
    {
        $rules = array(
            array('friend_email, route_id', 'required', 'message' => 'Введите {attribute}'),
            array('own_email, friend_email', 'email', 'message' => 'Введите правильный E-mail'),
            array('message', 'safe'),
        );

        if (Yii::app()->user->isGuest)
            $rules [] = array('own_email', 'required', 'message' => 'Введите {attribute}');

        return $rules;
    }

    function attributeLabels()
    {
        return array(
            'own_email' => 'Свой E-mail',
            'friend_email' => 'E-mail друга',
            'message' => 'Сообщение',
        );
    }

    /**
     * Returns the list of attribute names of the model.
     * @return array list of attribute names.
     */
    public function attributeNames()
    {
        return array();
    }

    public function send()
    {
        $route = Route::model()->findByPk($this->route_id);
        $title = $route->getTexts();
        $title = $title[0];
        if (!empty($this->message))
            $email_text = $this->message . '<br>' . '<br>' .$title  . '<br>' .$route->getUrl(true);
        else
            $email_text = $title . '<br>' . $this->message . '<br>' . $route->getUrl(true);
        $subject = $title;

        if (!Yii::app()->user->isGuest) {
            $user = Yii::app()->user->getModel();
            $fromName = $user->getFullName();
            $this->own_email = $user->email;
        } else
            $fromName = 'От друга';

        //$to, $subject, $body_html, $from, $fromName
        Yii::app()->email->sendEmail($this->friend_email, $subject, $email_text, $this->own_email, $fromName);
    }
}
