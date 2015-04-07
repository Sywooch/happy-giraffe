<?php

namespace site\frontend\modules\som\modules\community\controllers;

use \site\frontend\modules\posts\models\Content;

/**
 * Description of NewsController
 *
 * @author Кирилл
 */
class NewsController extends \site\frontend\modules\posts\controllers\ListController
{
    public $layout = 'news';
    public $forum = null;
    public $rubric = null;

    public function getListDataProvider()
    {
        $labels = array($this->forum->toLabel());
        if($this->rubric) {
            $labels[] = $this->rubric->toLabel();
        }
        $criteria = Content::model()->byLabels($labels)->orderDesc()->getDbCriteria();
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
        $this->forum = \Community::model()->findByPk(36);
        $rubricId = \Yii::app()->request->getQuery('rubric_id');
        if($rubricId) {
            $this->rubric = \CommunityRubric::model()->findByPk($rubricId);
        }
        $this->listDataProvider = $this->getListDataProvider();
        $this->render('list');
    }
}
