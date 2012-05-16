<?php
/**
 * Author: choo
 * Date: 13.05.2012
 */
class ActivityController extends HController
{
    public function actionIndex()
    {
        Yii::import('application.widgets.activity.*');
        $this->render('index');
    }

    public function actionLive()
    {
        $live = CommunityContent::model()->full()->findAll(array(
            'limit' => 5,
            'order' => 'created DESC',
        ));

        $this->render('live', compact($live));
    }
}
