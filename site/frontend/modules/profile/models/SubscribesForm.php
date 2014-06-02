<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/05/14
 * Time: 16:51
 */


class SubscribesForm extends CFormModel
{
    public $daily;
    public $dialogues;
    public $comments;
    public $replies;
    public $answers;
    public $discussions;

    public function __construct($userId)
    {
        foreach ($this->attributeNames() as $name) {
            $this->$name = UserAttributes::get($userId, $name, true);
        }
    }

    public function attributeLabels()
    {
        return array(
            'daily' => 'Ежедневная рассылка о новом о сайте',
            'dialogues' => 'Новые сообщения в диалогах',
            'comments' => 'Новые комментарии к вашим записям, фото, видео',
            'replies' => 'Новые ответы на ваш комментарий',
            'answers' => 'Новые ответы на заданый вами вопрос',
            'discussions' => 'Новые комментарии к записи в обсуждении которой вы принимали участие',
        );
    }

    public function toJSON()
    {
        return CJSON::encode($this->attributes);
    }
} 