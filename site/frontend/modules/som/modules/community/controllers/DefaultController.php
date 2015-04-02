<?php

namespace site\frontend\modules\som\modules\community\controllers;

use \site\frontend\modules\posts\models\Content;

/**
 * Description of DefaultController
 *
 * @author Кирилл
 */
class DefaultController extends \site\frontend\modules\posts\controllers\ListController
{

    public $layout = 'community';
    public $club = null;

    public function getListDataProvider()
    {
        $criteria = Content::model()->byLabels(array($this->club->toLabel()))->orderDesc()->getDbCriteria();
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
        $clubSlug = \Yii::app()->request->getQuery('club');
        $club = \CommunityClub::model()->findByAttributes(array('slug' => $clubSlug));
        if (is_null($club)) {
            throw new \CHttpException(404);
        }
        $this->club = $club;
        $this->listDataProvider = $this->getListDataProvider();
        $this->render('list');
    }

}
