<?php

class CookSpicesController extends BController
{
    public $defaultAction = 'admin';
    public $section = 'club';
    public $layout = '//layouts/club';
    public $_class = 'CookSpice';
    public $authItem = 'cook_spices';

    public function actions()
    {
        return array(
            'delete' => 'application.components.actions.Delete',
            'admin' => 'application.components.actions.Admin',
            'addPhoto' => 'application.components.actions.UploadPhoto'
        );
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
}
