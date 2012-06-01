<?php

class CookIngredientsController extends BController
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

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new CookIngredients;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CookIngredients'])) {
            $model->attributes = $_POST['CookIngredients'];
            if ($model->save()) {
                $iunit = new CookIngredientUnits();
                $iunit->attributes = array('ingredient_id' => $model->id, 'unit_id' => 1);
                $iunit->save();
                $this->redirect(array('update', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $basePath = Yii::getPathOfAlias('application.views.club.cookIngredients.assets');
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);

        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CookIngredients'])) {
            $model->attributes = $_POST['CookIngredients'];
            if ($model->save())
                $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
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

    /**
     *
     * Delete nutritional from ingredient
     *
     * @param $id
     * @throws CHttpException
     */
    public function actionUnlinkNutritional($id)
    {
        if (Yii::app()->request->isPostRequest) {
            $link = CookIngredientsNutritionals::model()->findByPk((int)$id);
            $model = $this->loadModel($link->ingredient_id);

            $link->delete();

            $this->renderPartial('_form_nutritionals_list', array('model' => $model));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     *  Add Nutritional with value to ingredient
     */
    public function actionLinkNutritional()
    {
        $link = new CookIngredientsNutritionals();
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'cook-ingredients-nutritionals-create-form') {
            $link->attributes = $_POST['CookIngredientsNutritionals'];
            echo CActiveForm::validate($link);
            Yii::app()->end();
        } elseif (isset($_POST['CookIngredientsNutritionals'])) {
            $link->attributes = $_POST['CookIngredientsNutritionals'];
            $link->save();
            $model = $this->loadModel($link->ingredient_id);
            $this->renderPartial('_form_nutritionals_list', array('model' => $model));
        }
    }

    /**
     *    Create synonym of an ingredient
     */
    public function actionCreateSynonym()
    {
        $synonym = new CookIngredientSynonyms();
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'cook-ingredients-synonyms-create-form') {
            $synonym->attributes = $_POST['CookIngredientSynonyms'];
            echo CActiveForm::validate($synonym);
            Yii::app()->end();
        } elseif (isset($_POST['CookIngredientSynonyms'])) {
            $synonym->attributes = $_POST['CookIngredientSynonyms'];
            $synonym->save();
            $model = $this->loadModel($synonym->ingredient_id);
            $this->renderPartial('_form_synonyms_list', array('model' => $model));
        }
    }

    /**
     * Delete Synonym
     *
     * @param $id
     * @throws CHttpException
     */
    public function actionDeleteSynonym($id)
    {
        if (Yii::app()->request->isPostRequest) {
            $synonym = CookIngredientSynonyms::model()->findByPk((int)$id);
            $model = $this->loadModel($synonym->ingredient_id);

            $synonym->delete();

            $this->renderPartial('_form_synonyms_list', array('model' => $model));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new CookIngredients('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['CookIngredients']))
            $model->attributes = $_GET['CookIngredients'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = CookIngredients::model()->findByPk((int)$id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'cook-ingredients-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionSaveUnits($id)
    {
        foreach ($_POST['units'] as $unit_id => $unit) {
            $model = CookIngredientUnits::model()->findByAttributes(array('ingredient_id' => $id, 'unit_id' => $unit_id));
            if (isset($unit['cb'])) {
                if ($model) {
                    $model->weight = $unit['weight'];
                    $model->save();
                } else {
                    $model = new CookIngredientUnits();
                    $model->attributes = array('ingredient_id' => $id, 'unit_id' => $unit_id, 'weight' => $unit['weight']);
                    $model->save();
                }
            } else {
                if ($model)
                    $model->delete();
            }
        }
    }

    // temp method to fill Ingredient units

    /*public function actionFillUnits()
    {
        set_time_limit(0);
        $ingredients = CookIngredients::model()->findAll();
        $units = CookUnit::model()->findAll();

        foreach ($ingredients as $ingredient) {
            $s = array();
            $s[] = array('ingredient_id' => $ingredient->id, 'unit_id' => 1);

            if ($ingredient->unit->type == 'qty' and $ingredient->weight > 0) {
                $s[] = array('ingredient_id' => $ingredient->id, 'unit_id' => $ingredient->unit_id, 'weight' => $ingredient->weight);
            }

            if ($ingredient->density > 0) {
                foreach ($units as $unit) {
                    if ($unit->type == 'volume') {
                        $s[] = array('ingredient_id' => $ingredient->id, 'unit_id' => $unit->id);
                    }
                }
            }

            foreach ($s as $ss) {
                //continue;
                $model = new CookIngredientUnits();
                $model->attributes = $ss;
                $model->save();
            }
        }
    }*/
}
