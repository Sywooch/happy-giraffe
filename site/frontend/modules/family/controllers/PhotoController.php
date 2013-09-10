<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 8/30/13
 * Time: 3:44 PM
 * To change this template use File | Settings | File Templates.
 */

class PhotoController extends HController
{
    public function actionMeUpload()
    {
        $photo = AlbumPhoto::model()->createUserTempPhoto($_FILES['photo']);

        $attach = new AttachPhoto();
        $attach->entity = 'User';
        $attach->entity_id = Yii::app()->user->id;
        $attach->photo_id = $photo->id;
        $attach->save();

        $response = array(
            'photo' => array(
                'id' => $photo->id,
                'bigThumbSrc' => $photo->getPreviewUrl(220, null, Image::WIDTH),
                'smallThumbSrc' => $photo->getPreviewUrl(null, 105, Image::HEIGHT),
            ),
        );
        echo CJSON::encode($response);
    }

    public function actionPartnerUpload()
    {
        $photo = AlbumPhoto::model()->createUserTempPhoto($_FILES['photo']);

        $attach = new AttachPhoto();
        $attach->entity = 'UserPartner';
        $attach->entity_id = Yii::app()->user->model->partner->id;
        $attach->photo_id = $photo->id;
        $attach->save();

        $response = array(
            'photo' => array(
                'id' => $photo->id,
                'bigThumbSrc' => $photo->getPreviewUrl(220, null, Image::WIDTH),
                'smallThumbSrc' => $photo->getPreviewUrl(null, 105, Image::HEIGHT),
            ),
        );
        echo CJSON::encode($response);
    }

    public function actionBabyUpload()
    {
        $photo = AlbumPhoto::model()->createUserTempPhoto($_FILES['photo']);
        $id = Yii::app()->request->getPost('id');

        $attach = new AttachPhoto();
        $attach->entity = 'Baby';
        $attach->entity_id = $id;
        $attach->photo_id = $photo->id;
        $attach->save();

        $response = array(
            'id' => $id,
            'photo' => array(
                'id' => $photo->id,
                'bigThumbSrc' => $photo->getPreviewUrl(220, null, Image::WIDTH),
                'smallThumbSrc' => $photo->getPreviewUrl(null, 105, Image::HEIGHT),
            ),
        );
        echo CJSON::encode($response);
    }

    public function actionSetMainPhoto()
    {
        $entityName = Yii::app()->request->getPost('entityName');
        $entityId = Yii::app()->request->getPost('entityId');
        $photoId = Yii::app()->request->getPost('photoId');

        $success = CActiveRecord::model($entityName)->updateByPk($entityId, array('main_photo_id' => $photoId)) > 0;
        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionUnsetMainPhoto()
    {
        $entityName = Yii::app()->request->getPost('entityName');
        $entityId = Yii::app()->request->getPost('entityId');

        $success = CActiveRecord::model($entityName)->updateByPk($entityId, array('main_photo_id' => null)) > 0;
        $response = compact('success');
        echo CJSON::encode($response);
    }
}