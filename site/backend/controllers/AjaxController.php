<?php

class AjaxController extends BController
{
    public function actionEditInput($class, $id, $text, $attribute){
        $model = CActiveRecord::model($class)->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        $model->setAttribute($attribute, $text);

        echo $model->update(array($attribute));
    }

    public function actionDelete($class, $id){
        $model = CActiveRecord::model($class)->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        echo $model->delete();
    }

    public function actionOnOff()
    {
        $modelName = Yii::app()->request->getPost('modelName');
        $modelPk = Yii::app()->request->getPost('modelPk');
        $model = CActiveRecord::model($modelName)->findByPk($modelPk);
        $model->active = ! $model->active;
        echo $model->save(true, array('active'));
    }

    public function actionSetValue($class, $id, $attribute, $value){
        $model = CActiveRecord::model($class)->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $model->setAttribute($attribute, $value);
        echo $model->update(array($attribute));
    }
}
