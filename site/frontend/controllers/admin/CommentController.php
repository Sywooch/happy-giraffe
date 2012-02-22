<?php

class CommentController extends Controller
{
    public $layout = '//layouts/main';
    private $_model;

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('update'),
                'users' => array('@'),
            ),
        );
    }

    public function actionUpdate()
    {
        $model = $this->loadModel();

        if ($model->author_id == Yii::app()->user->getId() ||
            Yii::app()->authManager->checkAccess('редактирование комментариев', Yii::app()->user->getId())
        ) {
            if (isset($_POST['Comment']['text'])) {
                $model->text = $_POST['Comment']['text'];

                if ($model->save()) {
                    $class = $model->model;
                    $link = $class::getLink($model->object_id);
                    $this->redirect($link);
                }
            }

            $this->render('update', array(
                'model' => $model,
            ));
        }
    }

    /**
     * @return Comment
     * @throws CHttpException
     */
    public function loadModel()
    {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = Comment::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
        return $this->_model;
    }
}
