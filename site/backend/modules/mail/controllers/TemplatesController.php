<?php
/**
 * User: Eugene
 * Date: 25.06.12
 */
class TemplatesController extends BController
{
    public $layout = '//layouts/club';
    public $defaultAction = 'index';
    public $section = 'club';

    public function actionIndex()
    {
        $model = new MailTemplate('search');
        $this->render('index', compact('model'));
    }

    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        if (isset($_POST['MailTemplate'])) {
            $model->attributes = $_POST['MailTemplate'];
            if ($model->save())
                $this->redirect(array('index'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function loadModel($id)
    {
        $model = MailTemplate::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}
