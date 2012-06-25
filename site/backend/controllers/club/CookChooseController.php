<?php

class CookChooseController extends BController
{
    public $defaultAction = 'admin';
    public $section = 'club';
    public $layout = '//layouts/club';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('cook_choose'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }


    public function actionCreate()
    {
        $model = new CookChoose;

        if (isset($_POST['CookChoose'])) {
            $model->attributes = $_POST['CookChoose'];
            if ($model->save())
                $this->redirect(array('update', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CookChoose'])) {
            $model->attributes = $_POST['CookChoose'];
            if ($model->save())
                $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAdmin()
    {
        $model = new CookChoose('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['CookChoose']))
            $model->attributes = $_GET['CookChoose'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id)
    {
        $model = CookChoose::model()->findByPk((int)$id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'cook-choose-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
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
