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
        $entity = Yii::app()->request->getPost('entity');
        $entity_id = Yii::app()->request->getPost('entity_id');

        $success = Favourite::model()->deleteAllByAttributes(array(
            'entity' => $entity,
            'entity_id' => $entity_id,
            'user_id' => Yii::app()->user->id,
        )) > 0;

        $response = compact('success');
        echo CJSON::encode($response);
    }
}
