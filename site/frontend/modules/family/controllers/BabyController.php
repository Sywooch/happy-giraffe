<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 8/29/13
 * Time: 11:57 AM
 * To change this template use File | Settings | File Templates.
 */

class BabyController extends HController
{
    public function actionUpdateAttribute()
    {
        $attribute = Yii::app()->request->getPost('attribute');
        $value = Yii::app()->request->getPost('value');
        $id = Yii::app()->request->getPost('id');
        $baby = Baby::model()->findByPk($id);
        $baby->$attribute = $value;
        if ($baby->parent_id != Yii::app()->user->id)
            $success = false;
        else
            $success = $baby->save(true, array($attribute));
        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionUpdateBirthday()
    {
        $id = Yii::app()->request->getPost('id');
        $value = Yii::app()->request->getPost('value');
        $baby = Baby::model()->findByPk($id);
        $baby->birthday = $value;
        if ($baby->parent_id != Yii::app()->user->id)
            $success = false;
        else
            $success = $baby->save(true, array('birthday', 'age_group'));
        $response = compact('success');
        if ($success && $baby->type === null) {
            $response['ageGroup'] = $baby->age_group;
            $response['age'] = $baby->getTextAge();
        }
        else
            $response['error'] = $baby->getError('birthday');
        echo CJSON::encode($response);
    }

    public function actionRemove()
    {
        $id = Yii::app()->request->getPost('id');
        $success = Baby::model()->updateByPk($id, array('removed' => 1)) > 0;
        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionRestore()
    {
        $id = Yii::app()->request->getPost('id');
        $success = Baby::model()->updateByPk($id, array('removed' => 0)) > 0;
        $response = compact('success');
        echo CJSON::encode($response);
    }
}