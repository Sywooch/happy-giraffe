<?php

class CookChooseCategoryController extends HController
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

    /*public function actionCreate()
     {
         $model=new CookChooseCategory;

         // Uncomment the following line if AJAX validation is needed
         // $this->performAjaxValidation($model);

         if(isset($_POST['CookChooseCategory']))
         {
             $model->attributes=$_POST['CookChooseCategory'];
             if($model->save())
                 $this->redirect(array('admin'));
         }

         $this->render('create',array(
             'model'=>$model,
         ));
     }*/


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CookChooseCategory'])) {
            $model->attributes = $_POST['CookChooseCategory'];
            if ($model->save())
                $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }


    /*public function actionDelete($id)
     {
         if(Yii::app()->request->isPostRequest)
         {
             // we only allow deletion via POST request
             $this->loadModel($id)->delete();

             // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
             if(!isset($_GET['ajax']))
                 $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
         }
         else
             throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
     }*/


    public function actionAdmin()
    {
        $model = new CookChooseCategory('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['CookChooseCategory']))
            $model->attributes = $_GET['CookChooseCategory'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }


    public function loadModel($id)
    {
        $model = CookChooseCategory::model()->findByPk((int)$id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }


    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'cook-choose-category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
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
