<?php
/**
 * Форма вопроса специалисту
 *
 * @property CommunityContent $post
 * @property User $user
 */

class CommunityQuestionForm extends CFormModel
{
    const FORUM_ID = 2;
    const RUBRIC_TITLE = 'Вопросы будущих мам';

    public $title;
    public $text;
    public $first_name;
    public $email;

    private $_post;
    private $_user;

    public function __construct()
    {
        $this->setScenario(Yii::app()->user->isGuest ? 'guest' : 'registered');
    }

    public function rules()
    {
        return array(
            array('title, text', 'required'),
            array('first_name, email', 'required', 'on' => 'guest'),
            array('email', 'email'),
            array('email', 'unique', 'className' => 'User', 'criteria' => array('condition' => 'deleted = 0'))
        );
    }

    public function attributeLabels()
    {
        return array(
            'title' => 'Тема вопроса',
            'text' => 'Вопрос',
            'first_name' => 'Имя',
            'email' => 'E-mail',
        );
    }

    public function getPost()
    {
        return $this->_post;
    }

    public function getUser()
    {
        return $this->_user;
    }

    public function save()
    {
        $this->_post = new CommunityContent();
        $this->_post->attributes = $this->attributes;
        $this->_post->rubric_id = $this->getRubric()->id;
        $this->_post->type_id = CommunityContent::TYPE_QUESTION;

        $question = new CommunityQuestion();
        $question->attributes = $this->attributes;
        $this->_post->question = $question;

        if ($this->scenario == 'guest') {
            $this->_user = new User();
            $this->_user->attributes = $this->attributes;
        } else
            $this->_user = Yii::app()->user->model;

        $this->_user->communityPosts = array($this->_post);

        $success = $this->_user->withRelated->save(true, array('communityPosts' => array('question')));
        if ($success && $this->scenario == 'guest')
            Yii::app()->user->setState('newUser', array(
                'id' => $this->_user->id,
                'email' => $this->_user->email,
                'first_name' => $this->_user->first_name,
            ));
        return $success;
    }

    protected function getRubric()
    {
        $criteria = new CDbCriteria();
        $criteria->compare('title', self::RUBRIC_TITLE);
        $criteria->compare('community_id', self::FORUM_ID);

        $rubric = CommunityRubric::model()->find($criteria);
        if ($rubric !== null)
            return $rubric;

        $rubric = new CommunityRubric();
        $rubric->title = 'Вопросы будущих мам';
        $rubric->community_id = self::FORUM_ID;
        return $rubric->save() ? $rubric : null;
    }
}