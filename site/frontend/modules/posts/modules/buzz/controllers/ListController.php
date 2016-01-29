<?php
namespace site\frontend\modules\posts\modules\buzz\controllers;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;

/**
 * @author Никита
 * @date 08/10/15
 */

class ListController extends \site\frontend\modules\posts\controllers\ListController
{
    public $layout = '/layout';

    protected $_club;

    public function getClub()
    {
        if (is_null($this->_club)) {
            $slug = \Yii::app()->request->getParam('slug');
            if ($slug) {
                $this->_club = \CommunityClub::model()->findByAttributes(array('slug' => $slug));
            } else {
                $this->_club = false;
            }
        }
        return $this->_club;
    }

    public function getTags()
    {
        $tags = array();
        $tags[] = Label::LABEL_BUZZ;
        if ($this->getClub()) {
            $tags[] = $this->getClub()->toLabel();
        }
        return $tags;
    }

    public function getListDataProvider()
    {
        return new \CActiveDataProvider(Content::model()->byLabels($this->getTags())->orderDesc(), array(
            'pagination' => array(
                'pageSize' => 10,
                'pageVar' => 'page',
            )
        ));
    }

    public function actionIndex()
    {
        $this->listDataProvider = $this->getListDataProvider();
        $this->render('list');
    }
}