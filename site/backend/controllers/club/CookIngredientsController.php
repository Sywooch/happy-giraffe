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
        $model = new CookIngredient;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CookIngredient'])) {
            $model->attributes = $_POST['CookIngredient'];
            if ($model->save()) {
                $iunit = new CookIngredientUnit();
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

        if (isset($_POST['CookIngredient'])) {
            $model->attributes = $_POST['CookIngredient'];
            if ($model->save())
                $this->redirect(array('update', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionUpdate2($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['CookIngredient'])) {
            $model->attributes = $_POST['CookIngredient'];
            if ($model->save())
                $this->redirect(array('update', 'id' => $model->id));
        }

        $this->render('update2', array(
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
            $link = CookIngredientNutritional::model()->findByPk((int)$id);
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
        $link = new CookIngredientNutritional();
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'cook-ingredients-nutritionals-create-form') {
            $link->attributes = $_POST['CookIngredientNutritional'];
            echo CActiveForm::validate($link);
            Yii::app()->end();
        } elseif (isset($_POST['CookIngredientNutritional'])) {
            $link->attributes = $_POST['CookIngredientNutritional'];
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
        $synonym = new CookIngredientSynonym();
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'cook-ingredients-synonyms-create-form') {
            $synonym->attributes = $_POST['CookIngredientSynonym'];
            echo CActiveForm::validate($synonym);
            Yii::app()->end();
        } elseif (isset($_POST['CookIngredientSynonym'])) {
            $synonym->attributes = $_POST['CookIngredientSynonym'];
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
            $synonym = CookIngredientSynonym::model()->findByPk((int)$id);
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
        $model = new CookIngredient('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['CookIngredient']))
            $model->attributes = $_GET['CookIngredient'];

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
        $model = CookIngredient::model()->findByPk((int)$id);
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
        $response = array('html', 'error');
        $ingredient = CookIngredient::model()->findByPk($id);
        $units = CookUnit::model()->findAll();

        foreach ($units as $unit) {
            $model = CookIngredientUnit::model()->findByAttributes(array('ingredient_id' => $ingredient->id, 'unit_id' => $unit->id));
            if (isset($_POST['units'][$unit->id]['cb'])) {
                if ($model) {
                    if (isset($_POST['units'][$unit->id]['weight']))
                        $model->weight = $_POST['units'][$unit->id]['weight'];
                } else {
                    $model = new CookIngredientUnit();
                    $model->attributes = array(
                        'ingredient_id' => $ingredient->id,
                        'unit_id' => $unit->id,
                        'weight' => (isset($_POST['units'][$unit->id]['weight'])) ? $_POST['units'][$unit->id]['weight'] : 0
                    );
                }

                if ($unit->type == 'volume' && $ingredient->density == 0) {
                    $response['error'] .= '<strong>' . $unit->title . '</strong> недопустима т.к. не задана плотность ингредиента<br>';
                    if ($model->id)
                        $model->delete();
                    continue;
                }
                if (($unit->type == 'qty') && !isset($_POST['units'][$unit->id]['weight'])) {
                    $response['error'] .= '<strong>' . $unit->title . '</strong> недопустима т.к. не указан вес для этой ед.изм.<br>';
                    if ($model->id)
                        $model->delete();
                    continue;
                }

                $model->save();

            } else {
                if ($model)
                    $model->delete();
            }

        }

        $response['html'] = $this->renderPartial('_form_units', array('model' => $ingredient), true);
        if ($response['error'] == '')
            $response['error'] = 'Сохранено успешно';


        header('Content-type: application/json');
        echo CJSON::encode($response);
    }

}
