<?php
namespace site\frontend\modules\som\modules\community\controllers;
use site\frontend\modules\posts\controllers\ListController;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;

/**
 * Description of NewsController
 *
 * @author Кирилл
 */
class NewsController extends ListController
{
    public $layout = 'news';

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
        $tags[] = Label::LABEL_NEWS;
        if ($this->getClub()) {
            $tags[] = $this->getClub()->toLabel();
        }
        return $tags;
    }


    public function getListDataProvider()
    {
        $criteria = Content::model()->byLabels($this->getTags())->orderDesc()->getDbCriteria();
        return new \CActiveDataProvider('\site\frontend\modules\posts\models\Content', array(
            'criteria' => clone $criteria,
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
