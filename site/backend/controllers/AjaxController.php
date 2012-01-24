<?php

class AjaxController extends BController
{
    public function actionDelete()
    {
        $modelName = Yii::app()->request->getPost('modelName');
        $modelPk = Yii::app()->request->getPost('modelPk');

        $model = CActiveRecord::model($modelName)->findByPk($modelPk);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        if ($model->asa('tree') instanceof NestedSetBehavior) {
            echo $model->deleteNode();
        }
        else
        {
            echo $model->delete();
        }
    }

    public function actionOnOff()
    {
        $modelName = Yii::app()->request->getPost('modelName');
        $modelPk = Yii::app()->request->getPost('modelPk');

        $model = CActiveRecord::model($modelName)->findByPk($modelPk);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $model->active = !$model->active;
        $model->disableBehavior('tree');
        echo $model->update(array('active'));
    }

    public function actionSetValue()
    {
        $modelName = Yii::app()->request->getPost('modelName');
        $modelPk = Yii::app()->request->getPost('modelPk');
        $attribute = Yii::app()->request->getPost('attribute');
        $value = Yii::app()->request->getPost('value');

        /**
         * @var CActiveRecord $model
         */
        $model = new $modelName;
        $res = Yii::app()->db->createCommand()
            ->update($model->tableName(),
            array($attribute => $value),
            $model->getTableSchema()->primaryKey.' = '.$modelPk);

        if ($res >= 0)
            echo '1';
    }

    public function actionSetValueAR()
    {
        $modelName = Yii::app()->request->getPost('modelName');
        $modelPk = Yii::app()->request->getPost('modelPk');
        $attribute = Yii::app()->request->getPost('attribute');
        $value = Yii::app()->request->getPost('value');

        $model = CActiveRecord::model($modelName)->findByPk($modelPk);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $model->setAttribute($attribute, $value);
        echo $model->update(array($attribute));
    }
}
