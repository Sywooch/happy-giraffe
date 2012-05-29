<?php

class CookSpicesController extends BController
{
    public $defaultAction = 'admin';
    public $section = 'club';
    public $layout = '//layouts/club';


    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('cook_ingredients'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionCreate()
    {
        $model = new CookSpices;

        $basePath = Yii::getPathOfAlias('application.views.club.cookSpices.assets');
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);

        if (isset($_POST['CookSpices'])) {
            $model->attributes = $_POST['CookSpices'];
            $model->categories = $_POST['category'];
            if ($model->save())

                $this->redirect(array('update', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
        Yii::app()->clientScript->registerCssFile($baseUrl . '/style.css', CClientScript::POS_HEAD);
    }

    public function actionUpdate($id)
    {

        $basePath = Yii::getPathOfAlias('application.views.club.cookSpices.assets');
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile($baseUrl . '/style.css', CClientScript::POS_HEAD);

        $model = $this->loadModel($id);

        if (isset($_POST['CookSpices'])) {
            $model->attributes = $_POST['CookSpices'];
            $model->categories = $_POST['category'];
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
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAdmin()
    {
        $model = new CookSpices('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['CookSpices']))
            $model->attributes = $_GET['CookSpices'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id)
    {
        $model = CookSpices::model()->with('categories')->findByPk((int)$id);
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
}
