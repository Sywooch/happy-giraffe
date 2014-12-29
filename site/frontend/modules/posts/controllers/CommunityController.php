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
    protected $_rubric = null;

    public function getClub()
    {
        if (is_null($this->_club)) {
            $id = \Yii::app()->request->getParam('forum_id');
            $this->_forum = \Community::model()->with(array('club', 'club.section'))->findByPk($id);
            $this->_club = $this->_forum->club;
        }

        return $this->_club;
    }

    public function getRubric()
    {
        if (is_null($this->_rubric)) {
            $this->_rubric = \CommunityRubric::model()->findByAttributes(array(
                'label_id' => \site\frontend\modules\posts\models\Label::getIdsByLabels($this->getTags()),
            ));
        }
        
        return $this->_rubric;
    }

    public function getForum()
    {
        if (is_null($this->_forum)) {
            $this->getClub();
        }
        return $this->_forum;
    }

    public function getTags()
    {
        return $this->post->labelsArray;
    }

    public function getLeftPost()
    {
        if (is_null($this->_leftPost)) {
            $this->_leftPost = Content::model()->byService('oldCommunity')->byTags($this->tags)->leftFor($this->post)->find();
        }

        return $this->_leftPost;
    }

    public function getRightPost()
    {
        if (is_null($this->_rightPost)) {
            $this->_rightPost = Content::model()->byService('oldCommunity')->byTags($this->tags)->rightFor($this->post)->find();
        }

        return $this->_rightPost;
    }

}
