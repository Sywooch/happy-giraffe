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
        $live = new CActiveDataProvider(CommunityContent::model()->full(), array(
            'criteria' => array(
                'order' => 'created DESC',
            ),
            'pagination' => array(
                'pageSize' => 5,
            ),
        ));

        $this->render('live', compact('live'));
    }
}
