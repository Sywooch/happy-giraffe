<?php

class CookChooseCategoryController extends BController
{

    public $defaultAction = 'admin';
    public $section = 'club';
    public $layout = '//layouts/club';
    public $_class = 'CookChooseCategory';
    public $authItem = 'cook_choose';


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
        $category = $this->loadModel($id);

        if (!empty($category->photo))
            $last_photo = $category->photo;

        if (isset($_FILES['photo']) && !empty($category)) {
            $file = CUploadedFile::getInstanceByName('photo');
            if (!in_array($file->extensionName, array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF')))
                Yii::app()->end();

            $photo = new AlbumPhoto();
            $photo->file = $file;
            $photo->title = $category->title;
            $photo->author_id = 1;

            if ($photo->create()) {
                echo "<script type='text/javascript'>
                document.domain = document.location.host;
                </script>";

                $category->photo_id = $photo->id;
                if ($category->save()) {
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
