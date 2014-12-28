<?php

namespace site\frontend\modules\posts\controllers;

use site\frontend\modules\posts\models\Content;

/**
 * Description of CommunityController
 *
 * @author Кирилл
 */
class CommunityController extends PostController
{

    public $litePackage = 'clubs';
    public $layout = '/layouts/newCommunityPost';
    protected $_club = null;
    protected $_forum = null;

    public function getClub()
    {
        if (is_null($this->_club)) {
            $id = \Yii::app()->request->getParam('forum_id');
            $this->_forum = \Community::model()->with(array('club', 'section'))->findByPk($id);
            $this->_club = $this->_forum->club;
        }

        return $this->_club;
    }

    public function getForum()
    {
        if (is_null($this->_forum)) {
            $this->getClub();
        }
        return $this->_forum;
    }

}
