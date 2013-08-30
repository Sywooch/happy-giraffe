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

    public function actionUploadPhoto()
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
        $this->renderPartial('/uploadPhoto', compact('response'));
    }
}