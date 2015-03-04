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

    public $view = 'list';
    public $setNoindexIfEmpty = false;
    public $setNoindexIfPage = false;
    public $pageVar = null;
    public $ownerId = false;
    public static $types = array(
        'comment' => array('comment', 'comment', array('добавила комментарий', 'добавил комментарий')),
        'photo' => array('photo', 'article', array('добавила фотографии', 'добавил фотографии')),
        'photoPost' => array('photopost', 'article', array('добавила фотопост', 'добавил фотопост')),
        'post' => array('article', 'article', array('добавила статью', 'добавил статью')),
        'advPost' => array('article', 'article', array('добавила статью', 'добавил статью')),
        'question' => array('article', 'article', array('добавила статью', 'добавил статью')),
        'status' => array('status', 'status', array('добавила статус', 'добавил статус')),
        'videoPost' => array('video', 'article', array('добавила видео', 'добавил видео')),
    );
    protected $_users = array();

    public function getDataProvider()
    {
        return new \CActiveDataProvider(Activity::model()->byUser($this->ownerId), array(
            'pagination' => array(
                'pageSize' => 10,
                'pageVar' => is_null($this->pageVar) ? $this->id : $this->pageVar,
            )
        ));
    }

    public function run()
    {
        if ($this->setNoindexIfPage && isset($_GET[$this->getDataProvider()->pagination->pageVar])) {
            $this->metaNoindex = true;
        };
        $this->render($this->view);
    }

    public function getUserInfo($id)
    {
        if (!isset($this->_users[$id])) {
            $this->_users[$id] = \site\frontend\components\api\models\User::model()->query('get', array('id' => (int) $id, 'avatarSize' => 72));
        }
        return $this->_users[$id];
    }

}
