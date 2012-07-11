<?php

class CookSpicesCategoriesController extends BController
{
    public $defaultAction = 'admin';
    public $section = 'club';
    public $layout = '//layouts/club';
    public $_class = 'CookSpiceCategory';
    public $authItem = 'cook_spices';

    public function actions()
    {
        return array(
            'update' => 'application.components.actions.Update',
            'admin' => 'application.components.actions.Admin'
        );
    }

    public function actionAddPhoto()
    {
        $id = Yii::app()->request->getPost('id');
        $spice = $this->loadModel($id);

        if (!empty($spice->photo))
            $last_photo = $spice->photo;

        if (isset($_FILES['photo']) && !empty($spice)) {
            $file = CUploadedFile::getInstanceByName('photo');
            if (!in_array($file->extensionName, array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF')))
                Yii::app()->end();

            $model = new AlbumPhoto();
            $model->file = $file;
            $model->title = $spice->title;
            $model->author_id = 1;

            if ($model->create()) {
                echo "<script type='text/javascript'>
                document.domain = document.location.host;
                </script>";

                $spice->photo_id = $model->id;
                if ($spice->save()) {
                    if (isset($last_photo))
                        $last_photo->delete();
                    $response = array(
                        'status' => true,
                        'image' => $model->getPreviewUrl()
                    );
                } else
                    $response = array('status' => false);
            } else
                $response = array('status' => false);

            echo CJSON::encode($response);
        }
    }
}
