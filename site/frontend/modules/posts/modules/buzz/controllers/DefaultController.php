<?php
namespace site\frontend\modules\posts\modules\buzz\controllers;
use site\frontend\modules\posts\controllers\ListController;
use site\frontend\modules\posts\models\Content;

/**
 * @author Никита
 * @date 08/10/15
 */

class DefaultController extends ListController
{
    const DEFAULT_TAG = 'Buzz';

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
        $tags[] = self::DEFAULT_TAG;
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