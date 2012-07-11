<?php

class CookChooseController extends BController
{
    public $defaultAction = 'admin';
    public $section = 'club';
    public $layout = '//layouts/club';
    public $_class = 'CookChoose';
    public $authItem = 'cook_choose';


    public function actions()
    {
        return array(
            'create' => 'application.components.actions.Create',
            'update' => 'application.components.actions.Update',
            'delete' => 'application.components.actions.Delete',
            'admin' => 'application.components.actions.Admin'
        );
    }

    public function actionAddPhoto()
    {
        $id = Yii::app()->request->getPost('id');
        $product = $this->loadModel($id);

        if (!empty($product->photo))
            $last_photo = $product->photo;

        if (isset($_FILES['photo']) && !empty($product)) {
            $file = CUploadedFile::getInstanceByName('photo');
            if (!in_array($file->extensionName, array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF')))
                Yii::app()->end();

            $photo = new AlbumPhoto();
            $photo->file = $file;
            $photo->title = $product->title;
            $photo->author_id = 1;

            if ($photo->create()) {
                echo "<script type='text/javascript'>
                document.domain = document.location.host;
                </script>";

                $product->photo_id = $photo->id;
                if ($product->save()) {
                    if (isset($last_photo))
                        $last_photo->delete();
                    $response = array(
                        'status' => true,
                        'image' => $photo->getPreviewUrl()
                    );
                } else
                    $response = array('status' => false);
            } else
                $response = array('status' => false);

            echo CJSON::encode($response);
        }
    }
}
