<?php

namespace site\frontend\modules\som\modules\activity\widgets;

use site\frontend\modules\som\modules\activity\models\Activity;

/**
 * Description of ActivityWidget
 *
 * @author Кирилл
 */
class ActivityWidget extends \CWidget
{
    public $criteria;
    public $view = 'list';
    public $setNoindexIfEmpty = false;
    public $setNoindexIfPage = false;
    public $pageVar = null;
    public $ownerId = false;
    public $pageSize = 10;
    public static $types = array(
        'comment' => array('comment', 'comment', array('добавила комментарий', 'добавил комментарий')),
        'photo' => array('photo', 'article', array('добавила фотографии', 'добавил фотографии')),
        'photoPost' => array('photopost', 'article', array('добавила фотопост', 'добавил фотопост')),
        'post' => array('article', 'article', array('добавила запись', 'добавил запись')),
        'advPost' => array('article', 'article', array('добавила запись', 'добавил запись')),
        'question' => array('article', 'article', array('добавила запись', 'добавил запись')),
        'status' => array('status', 'status', array('добавила статус', 'добавил статус')),
        'videoPost' => array('video', 'article', array('добавила видео', 'добавил видео')),
        Activity::TYPE_ANSWER_PEDIATRICIAN => ['comment', 'comment', ['ответила', 'ответил']]
    );
    protected $_users = array();

    /**
     * @return \CActiveDataProvider
     */
    public function getDataProvider()
    {
        $model = Activity::model();

        if (! $this->ownerId)
        {
            $model
                ->withoutAnswerPediatrician()
                ->withoutQuestion()
                ->excludePediatricianQuestions()
                ->excludePediatricianAnswers()
            ;
        }
        else
        {
            $model
                ->forUser($this->ownerId)
                ->excludePediatricianQuestions($this->ownerId)
            ;
        }

        return new \CActiveDataProvider($model, array(
            'pagination' => array(
                'pageSize' => $this->pageSize,
                'pageVar' => is_null($this->pageVar) ? $this->id : $this->pageVar,
            )
        ));
    }

    public function run()
    {
        $dp = $this->getDataProvider();

        if ($this->setNoindexIfPage && isset($_GET[$dp->pagination->pageVar]))
        {
            $this->owner->metaNoindex = true;
        };

        $this->render($this->view, compact('dp'));
    }

    public function getUserInfo($id)
    {
        if (!isset($this->_users[$id])) {
            $this->_users[$id] = \site\frontend\components\api\models\User::model()->query('get', array('id' => (int) $id, 'avatarSize' => 72));
        }

        return $this->_users[$id];
    }

}
