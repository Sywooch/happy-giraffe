<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 8/29/13
 * Time: 11:57 AM
 * To change this template use File | Settings | File Templates.
 */

class PartnerController extends HController
{
    public $partner;

    public function init()
    {
        $this->partner = Yii::app()->user->model->partner;
    }

    public function actionUpdateAttribute()
    {
        $attribute = Yii::app()->request->getPost('attribute');
        $value = Yii::app()->request->getPost('value');
        $this->partner->$attribute = $value;
        $success = $this->partner->save(true, array($attribute));
        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionUploadPhoto()
    {
        $photo = AlbumPhoto::model()->createUserTempPhoto($_FILES['photo']);

        $attach = new AttachPhoto();
        $attach->entity = 'UserPartner';
        $attach->entity_id = $this->partner->id;
        $attach->photo_id = $photo->id;
        $attach->save();

        $response = array(
            'id' => $photo->id,
            'bigThumbSrc' => $photo->getPreviewUrl(220, null, Image::WIDTH),
            'smallThumbSrc' => $photo->getPreviewUrl(null, 105, Image::HEIGHT),
        );
        $this->renderPartial('/uploadPhoto', compact('response'));
    }
}