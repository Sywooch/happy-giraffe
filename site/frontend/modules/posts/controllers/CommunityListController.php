<?php

namespace site\frontend\modules\posts\controllers;

use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;

/**
 * Description of CommunityController
 *
 * @author Кирилл
 */
class CommunityListController extends ListController
{
    
    public $litePackage = 'clubs';
    public $layout = '/layouts/newCommunityPost';
    protected $_club = null;
    protected $_forum = null;
    protected $_rubric = null;
    
    /**
     * {@inheritDoc}
     * @see LiteController::beforeAction()
     */
    protected function beforeAction($action)
    {        
        if ($action->id === $action->controller->defaultAction)
        {
            $rubricId = \Yii::app()->request->getParam('rubric_id');
            
            $url = $this->createUrl('/posts/forums/club/rubric', compact('rubricId'));
            
            $this->redirect($url, TRUE, 301);
        }
        
        parent::beforeAction($action);
    }
    
    public function getClub()
    {
        if (is_null($this->_club))
        {
            $id = \Yii::app()->request->getParam('forum_id');
            $this->_forum = \Community::model()->with(array('club', 'club.section'))->findByPk($id);
            $this->_club = $this->_forum->club;
            if (is_null($this->_club))
            {
                // Так случилось, что в некоторых форумах нету клубов, и это не про текущие посты.
                throw new \CHttpException(404);
            }
        }

        return $this->_club;
    }

    public function getRubric()
    {
        $id = \Yii::app()->request->getParam('rubric_id');
        if (is_null($this->_rubric) && !is_null($id))
        {
            $this->_rubric = \CommunityRubric::model()->findByPk($id);
        }

        return $this->_rubric;
    }

    public function getForum()
    {
        if (is_null($this->_forum))
        {
            $this->getClub();
        }
        return $this->_forum;
    }

    public function getTags()
    {
        $tags = array(Label::LABEL_FORUMS);
        $rubric = $this->getRubric();
        while ($rubric)
        {
            $tags[] = 'Рубрика: ' . $rubric->title;
            $rubric = $rubric->parent;
        }
        $tags[] = 'Форум: ' . $this->forum->title;
        $tags[] = 'Клуб: ' . $this->club->title;
        $tags[] = 'Секция: ' . $this->club->section->title;

        return $tags;
    }

    public function getListDataProvider()
    {
        $criteria = Content::model()->createCriteriaForForum($this->tags);
        return new \CActiveDataProvider('\site\frontend\modules\posts\models\Content', array(
            'criteria' => clone $criteria,
            'pagination' => array(
                'pageSize' => 10,
                'pageVar' => 'CommunityContent_page',
            )
        ));
    }

    public function actionIndex()
    {
        $this->listDataProvider = $this->getListDataProvider();
        $this->render('list');
    }

}
