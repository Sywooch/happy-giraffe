<?php

class PageController extends SController
{
    public $defaultAction = 'admin';
    public $layout = '//layouts/empty';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionAddKeywords()
    {
        $page = $this->loadModel(Yii::app()->request->getPost('id'));
        $keywords = trim(Yii::app()->request->getPost('keywords'));
        $keywords = explode("\n", $keywords);

        $result = $page->keywordGroup->keywords;
        foreach ($keywords as $key) {
            $keyword = trim($key);
            if (!empty($keyword)) {
                $keyword = Keyword::GetKeyword($keyword);
                $exist = false;
                foreach ($result as $k)
                    if ($k->id == $keyword->id)
                        $exist = true;

                if (!$exist)
                    $result [] = $keyword;
            }
        }
        $page->keywordGroup->keywords = $result;

        if ($page->keywordGroup->withRelated->save(true, array('keywords')))
            echo CJSON::encode(array('status' => true));
        else
            var_dump($page->keywordGroup->getErrors());
    }

    public function actionRemoveKeyword()
    {
        $page = $this->loadModel(Yii::app()->request->getPost('id'));
        $keyword_id = Yii::app()->request->getPost('keyword_id');
        $page->keywordGroup->removeKeyword($keyword_id);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Page;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Page'])) {
            $model->attributes = $_POST['Page'];
            $group = new KeywordGroup;
            $group->save();
            $model->keyword_group_id = $group->id;
            if ($model->save())
                $this->redirect($this->createUrl('update', array('id'=>$model->id)));
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
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Page'])) {
            $model->attributes = $_POST['Page'];
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
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Page('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Page']))
            $model->attributes = $_GET['Page'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * @param $id
     * @return Page
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Page::model()->findByPk((int)$id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'page-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
