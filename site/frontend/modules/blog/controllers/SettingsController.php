<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 6/26/13
 * Time: 1:26 PM
 * To change this template use File | Settings | File Templates.
 */

class SettingsController extends HController
{
    public function actionRubricEdit()
    {
        $id = Yii::app()->request->getPost('id');
        $title = Yii::app()->request->getPost('title');
        $rubric = CommunityRubric::model()->findByPk($id);
        $rubric->title = $title;
        $success = $rubric->save(true, array('title'));
        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionRubricRemove()
    {
        $id = Yii::app()->request->getPost('id');
        $success = CommunityRubric::model()->deleteByPk($id) > 0;
        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionRubricCreate()
    {
        $title = Yii::app()->request->getPost('title');
        $rubric = new CommunityRubric();
        $rubric->title = $title;
        $rubric->user_id = Yii::app()->user->id;
        $success = $rubric->save();
        $response = compact('success');
        if ($success)
            $response['id'] = $rubric->id;
        echo CJSON::encode($response);
    }
}