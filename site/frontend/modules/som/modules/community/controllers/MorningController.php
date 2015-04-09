<?php

namespace site\frontend\modules\som\modules\community\controllers;

use \site\frontend\modules\posts\models\Content;

/**
 * Description of MorningController
 *
 * @author Кирилл
 */
class MorningController extends \site\frontend\modules\posts\controllers\ListController
{

    public $layout = 'morning';
    public $forum = null;
    public $rubric = null;

    public function getListDataProvider()
    {
        $criteria = Content::model()->byService('oldMorning')->orderDesc()->getDbCriteria();
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
