<?php

class CookSpicesController extends BController
{
    public $defaultAction = 'admin';
    public $section = 'club';
    public $layout = '//layouts/club';


    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('cook_spices'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionCreate()
    {
        $model = new CookSpice;

        if (isset($_POST['CookSpice'])) {

            if (!$_POST['CookSpice']['ingredient_id']) {
                $ingredient = new CookIngredient();
                $ingredient->attributes = array('title' => $_POST['ac'], 'category_id' => 41);
                $ingredient->save();
                $_POST['CookSpice']['ingredient_id'] = $ingredient->id;
            }

            $model->attributes = $_POST['CookSpice'];

            if (isset($_POST['category']))
                $model->categories = $_POST['category'];
            if ($model->save())
                $this->redirect(array('update', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id)
    {

        $basePath = Yii::getPathOfAlias('application.views.club.cookSpices.assets');
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile($baseUrl . '/style.css', CClientScript::POS_HEAD);

        $model = $this->loadModel($id);

        if (isset($_POST['CookSpice'])) {
            $model->attributes = $_POST['CookSpice'];
            if (isset($_POST['category']))
                $model->categories = $_POST['category'];
            else
                $model->categories = array();

            if ($model->save())
                $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'model' => $model
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
        $model = new CookSpice('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['CookSpice']))
            $model->attributes = $_GET['CookSpice'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * @param $id
     * @return CookSpice
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = CookSpice::model()->with('categories')->findByPk((int)$id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'cook-spices-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAc($term)
    {
        $ingredients = Yii::app()->db->createCommand()->select('id, unit_id, title, title AS label, title AS value')->from('cook__ingredients')
            ->where('title LIKE :term', array(':term' => '%' . $term . '%'))
            ->limit(20)->queryAll();
        header('Content-type: application/json');
        echo CJSON::encode($ingredients);
    }

    public function actionAddHint()
    {
        $hint = new CookSpicesHints();
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'spices-hints-form') {
            $hint->attributes = $_POST['CookSpicesHints'];
            echo CActiveForm::validate($hint);
            Yii::app()->end();
        } elseif (isset($_POST['CookSpicesHints'])) {
            $hint->attributes = $_POST['CookSpicesHints'];
            $hint->save();
            $model = $this->loadModel($hint->spice_id);
            $this->renderPartial('_form_hints', array('model' => $model));
        }
    }

    public function actionDeleteHint($id)
    {
        $hint = CookSpicesHints::model()->findByPk((int)$id);
        $model = $this->loadModel($hint->spice_id);
        $hint->delete();
        $this->renderPartial('_form_hints', array('model' => $model));
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
