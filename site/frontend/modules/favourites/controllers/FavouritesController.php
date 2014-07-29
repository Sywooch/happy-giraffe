<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 5/17/13
 * Time: 10:28 AM
 * To change this template use File | Settings | File Templates.
 */
class FavouritesController extends HController
{
    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
            ),
        );
    }

    public function actionCreate()
    {
        $favourite = new Favourite();
        $favourite->attributes = $_POST['Favourite'];
        $favourite->user_id = Yii::app()->user->id;
        $success = $favourite->withRelated->save(true, array('tags'));
        $response = compact('success');

        echo CJSON::encode($response);
    }

    public function actionUpdate()
    {
        $favouriteId = Yii::app()->request->getPost('favouriteId');

        $favourite = Favourite::model()->findByPk($favouriteId);
        if ($favourite === null)
            throw new CHttpException(400, 'Favourite does not exist');

        $favourite->attributes = $_POST['Favourite'];
        $success = $favourite->withRelated->save(true, array('tags'));
        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionDelete()
    {
        $modelName = Yii::app()->request->getPost('modelName');
        $modelId = Yii::app()->request->getPost('modelId');

        $success = false;
        $favorite = Favourite::model()->findByAttributes(array(
            'model_name' => $modelName,
            'model_id' => $modelId,
            'user_id' => Yii::app()->user->id,
        ));
        if($favorite)
            $success = $favorite->delete();

        $response = compact('success');
        echo CJSON::encode($response);

        //обновляет рейтинг
        $model = $modelName::model()->findByPk($modelId);
        if ($model)
            PostRating::reCalc($model);
    }
}
