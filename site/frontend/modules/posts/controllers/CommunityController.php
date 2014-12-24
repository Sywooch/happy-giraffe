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

    public function getClub()
    {
        if (is_null($this->_club)) {
            $id = \Yii::app()->request->getParam('forum_id');
            $this->_club = \Community::model()->with('club')->findByPk($id)->club;
        }
        
        return $this->_club;
    }

}
