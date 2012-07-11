<?php

class CookUnitController extends BController
{
    public $defaultAction = 'admin';
    public $section = 'club';
    public $layout = '//layouts/club';
    public $_class = 'CookUnit';
    public $authItem = 'cook_ingredients';

    public function actions()
    {
        return array(
            //'create' => 'application.components.actions.Create',
            'update' => 'application.components.actions.Update',
            'delete' => 'application.components.actions.Delete',
            'admin' => 'application.components.actions.Admin'
        );
    }

    public function actionCreate()
    {
        $model = new CookUnit;

        if (isset($_POST['CookUnit'])) {
            $model->attributes = $_POST['CookUnit'];
            $model->type = 'qty';
            $model->ratio = 1;
            if ($model->save())
                $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }
}
